<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Users;

/**
 * Class UsersTransformer.
 *
 * @package namespace App\Transformers;
 */
class UsersTransformer extends TransformerAbstract
{
    /**
     * Transform the Users entity.
     *
     * @param \App\Entities\Users $model
     *
     * @return array
     */
    public function transform(Users $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
