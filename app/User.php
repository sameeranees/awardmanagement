<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait, SoftDeletes {
        // resloved conflict of same method `restore`
        SoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::restore insteadof SoftDeletes;
    }

    /**
     * User Types 
     *
     */
    const SUPER_ADMIN = 'super_admin';
    const SYSTEM_USER = 'system_user';
    const RIDER       = 'rider';
    const CUSTOMER    = 'customer';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'token', 'status', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Accessors & Mutators [STARTS].
     *
     *
     * @return \Illuminate\Database\Eloquent
    */
    
    public function setStatusAttribute($value){
        $this->attributes['status'] = $value == 'on' ? 1 : 0;
    }

    // Accessors & Mutators [ENDS]
     
     /**
     * SCOPES [STARTS].
     *
     *
     * @return \Illuminate\Database\Eloquent
    */
    
    public function scopeType($query, $type){
        return $query->whereType($type);
    }

    public function scopeExceptMe($query){
        return $query->where('id', '!=', auth()->user()->id);
    }

    public function scopeExceptSuperAdmin($query){
        return $query->where('type', '!=', self::SUPER_ADMIN);
    }

    // SCOPES [ENDS]

    /**
     * RELATIONSHIPS [STARTS].
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations
    */

    // RELATIONSHIPS [ENDS]


    public static function search( $options = [] ) {


        if ( is_array($options) ) {
            $options = array_map(
                function ( $e ) {
                    return is_scalar( $e ) ? trim( $e ) : $e;
                }, $options
            );
        }

        $query = self::query()->exceptSuperAdmin()->exceptMe();

        #/ id
        if (isset($options['id']) &&  !is_null( $options['id'] ) && $options['id'] != "") {
            $query = $query->where( 'id', 'LIKE', '%' . $options['id'] . '%' );
        }

        #/ name
        if (isset($options['name']) &&  !is_null( $options['name'] ) && $options['name'] != "") {
            $query = $query->where( 'name', 'LIKE', '%' . $options['name'] . '%' );
        }

         #/ email
        if (isset($options['email']) &&  !is_null( $options['email'] ) && $options['email'] != "") {
            $query = $query->where( 'email', 'LIKE', '%' . $options['email'] . '%' );
        }

        #/ phone
        if (isset($options['phone']) &&  !is_null( $options['phone'] ) && $options['phone'] != "") {
            $query = $query->where( 'phone', 'LIKE', '%' . $options['phone'] . '%' );
        }

        #/ status
        if (isset($options['status']) &&  !is_null( $options['status'] ) && $options['status'] != -1) {
            $query = $query->where( 'status', 'LIKE', '%' . $options['status'] . '%' );
        }


        if (!$count = $query->count()) {
            return false;
        }

        $options['start'] = isset($options['start']) ? $options['start'] : 0;
        $options['length'] = isset($options['length']) ? $options['length'] : 25;

        
        $query->orderBy( $options['order_by'], $options['order_dir']);
        

        if ( $options['start'] ) {
            $query = $query->skip( $options['start'] );
        }

        if ( $options['length'] && $options['length'] > 0) {
            $query = $query->take( $options['length'] );
        }

        // dd ( $query->toSql() );
        //dd ( $query->get()->toArray() );
        return [
            'total' => $count,
            'result' => $query->get()
        ];
    }
}
