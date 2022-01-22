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
class Quote extends Model {
    //put your code here
    protected $table= 'quote';
    protected $fillable = [ 'user_id',"name",  "symbol",  "open" , "high",  "low",  "close"];
    protected $printable = [ "name",  "symbol",  "open" , "high",  "low",  "close"];
  
    public function __toString(){
    $data = '[';
    foreach ($this->printable as $c){
    $data .= $c.' - '.$this->{$c}.',';
        
    }
    $data .= ']';
        return  $data;
    }
    
}
