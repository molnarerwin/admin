<?php

declare(strict_types=1);

/**
 * Contains the CreateShippingMethod interface.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-25
 *
 */

namespace Vanilo\Admin\Contracts\Requests;

use Konekt\Concord\Contracts\BaseRequest;

interface CreateShippingMethod extends BaseRequest
{
    public function channels(): array;
}
