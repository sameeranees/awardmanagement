<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Degree extends Model
{
    //
    protected $guarded=[];
    protected $tablename='degrees';
    public $timestamps = false;
    public function setStatusAttribute($value){
        $this->attributes['status'] = $value == 'on' ? 1 : 0;
    }

	public function members()
    {
        return $this->hasMany('App\Member');
    }
    public function majors()
    {
        return $this->hasMany('App\Major');
    }

    public static function search( $options = [] ) {


        if ( is_array($options) ) {
            $options = array_map(
                function ( $e ) {
                    return is_scalar( $e ) ? trim( $e ) : $e;
                }, $options
            );
        }

        $query = self::query();

        #/ id
        if (isset($options['id']) &&  !is_null( $options['id'] ) && $options['id'] != "") {
            $query = $query->where( 'id', 'LIKE', '%' . $options['id'] . '%' );
        }

        #/ name
        if (isset($options['degree_name']) &&  !is_null( $options['degree_name'] ) && $options['degree_name'] != "") {
            $query = $query->where( 'degree_name', 'LIKE', '%' . $options['degree_name'] . '%' );
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
