<?php

namespace App\Model;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Eloquent\Model;

/**
 * Description of User
 *
 * @author marcel
 */
class User extends Model {
    //put your code here
    protected $table= 'users';
    protected $fillable = ['name','user','pass' ];
  
    
    
}
