<?php 

namespace App\Entities;

enum Transactiontype:string 
{
    case DEPOT = 'depot';
    case RETRAIT = 'retrait';
}