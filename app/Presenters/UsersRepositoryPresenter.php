<?php

namespace App\Presenters;

use App\Transformers\UsersRepositoryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UsersRepositoryPresenter.
 *
 * @package namespace App\Presenters;
 */
class UsersRepositoryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UsersRepositoryTransformer();
    }
}
