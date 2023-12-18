<?php

namespace App\Repositories;

use Illuminate\Container\Container as App;
use App\Eloquent\Repository;

class ConsultationsRepository extends Repository
{

   public function __construct(
      App $app
   ) {
      parent::__construct($app);
   }

   public function model()
   {
      return 'App\Models\Consultations';
   }
}
