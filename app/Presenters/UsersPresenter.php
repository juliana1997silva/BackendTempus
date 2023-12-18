<?php

namespace App\Presenters;

use App\Transformers\UsersTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UsersPresenter.
 *
 * @package namespace App\Presenters;
 */
class UsersPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UsersTransformer();
    }
}
