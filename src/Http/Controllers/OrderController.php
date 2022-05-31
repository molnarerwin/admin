<?php

declare(strict_types=1);

/**
 * Contains the OrderController class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-17
 *
 */

namespace Vanilo\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Admin\Contracts\Requests\UpdateOrder;
use Vanilo\Order\Contracts\Order;
use Vanilo\Order\Contracts\OrderAwareEvent;
use Vanilo\Order\Events\OrderWasCancelled;
use Vanilo\Order\Events\OrderWasCompleted;
use Vanilo\Order\Models\OrderProxy;
use Vanilo\Order\Models\OrderStatus;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        $query = OrderProxy::withCurrentPayment()->orderBy('created_at', 'desc');

        $inactives = $request->has('inactives');
        if (!$inactives) {
            $query->open();
        }
        return view('vanilo::order.index', [
            'orders' => $query->paginate(100),
            'inactives' => $inactives,
        ]);
    }

    public function show(Order $order, Request $request)
    {
        $view = $request->has('print') ? 'print' : 'show';
        if ('show' === $view) {
            $order = $order->with(['items', 'items.product'])->first();
        }

        return view("vanilo::order.$view", ['order' => $order]);
    }

    public function update(Order $order, UpdateOrder $request)
    {
        try {
            $event = null;
            if ($request->wantsToChangeOrderStatus($order)) {
                $event = $this->getStatusUpdateEventClass($request->getStatus(), $order);
            }

            $order->update($request->all());

            if (null !== $event) {
                event($event);
            }

            flash()->success(__('Order :no has been updated', ['no' => $order->number]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.admin.order.show', $order));
    }

    public function destroy(Order $order)
    {
        try {
            $number = $order->getNumber();
            $order->delete();

            flash()->warning(__('Order :no has been deleted', ['no' => $number]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.admin.order.index'));
    }

    private function getStatusUpdateEventClass(string $status, Order $order): ?OrderAwareEvent
    {
        if (OrderStatus::CANCELLED === $status) {
            return new OrderWasCancelled($order);
        }

        if (OrderStatus::COMPLETED === $status) {
            return new OrderWasCompleted($order);
        }

        return null;
    }
}
