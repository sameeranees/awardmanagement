<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    //
    protected $guarded=['formSelect','relatives','year'];
    public function setStatusAttribute($value){
        $this->attributes['status'] = $value == 'on' ? 1 : 0;
    }

    public function degree()
    {
        return $this->belongsTo('App\Degree');
    }
    public function major()
    {
        return $this->belongsTo('App\Major','majors_id');
    }
    /**
     * Get the comments for the blog post.
     */
    public function family_historys()
    {
        return $this->hasMany('App\MembersFamilyHistory');
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


        #/ name
        if (isset($options['first_name']) &&  !is_null( $options['first_name'] ) && $options['first_name'] != "") {
            $query = $query->where( 'first_name', 'LIKE', '%' . $options['first_name'] . '%' );
        }

        if (isset($options['surname']) &&  !is_null( $options['surname'] ) && $options['surname'] != "") {
            $query = $query->where( 'surname', 'LIKE', '%' . $options['surname'] . '%' );
        }
        
		if (isset($options['degree_name']) &&  !is_null( $options['degree_name'] ) && $options['degree_name'] != "") {
            $query->whereHas('degree', function($query)

            {
                # code...
                 $query = $query->where( 'degree_name', 'LIKE', '%' . $options['degree_name'] . '%' );
            });
           
        }

		if (isset($options['majors_name']) &&  !is_null( $options['majors_name'] ) && $options['majors_name'] != "") {
            $query->whereHas('major', function($query)

            {
                $query = $query->where( 'majors_name', 'LIKE', '%' . $options['majors_name'] . '%' );
            });        
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
