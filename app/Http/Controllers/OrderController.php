<?php

namespace AutoKit\Http\Controllers;

use AutoKit\Components\Delivery\Address;
use AutoKit\Components\Delivery\Services;
use AutoKit\Exceptions\DeliveryApi;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $deliveryAddress;

    protected $deliveryServices;

    public function __construct(Address $address, Services $services)
    {
        $this->middleware('order');
        $this->deliveryAddress = $address;
        $this->deliveryServices = $services;
    }

    public function index()
    {
        return view('order');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function delivery()
    {
        try {
            $regions = $this->deliveryAddress->getRegionList();
        } catch (DeliveryApi $e) {
            return response()->json(['message' => $e->getMessage()], 501);
        }
        return response()->json([
            'content' => view('partials.order.form.address', ['regions' => $regions])->render()
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function selfDelivery()
    {
        try {
            $selfDelivery = $this->deliveryAddress->getWarehousesInfo(config('delivery.warehouse_send_id'));
        } catch (DeliveryApi $e) {
            return response()->json(['message' => $e->getMessage()], 501);
        }
        return response()->json([
            'content' => view('partials.order.form.self_delivery', ['warehouse' => $selfDelivery])->render()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function region(Request $request)
    {
        try {
            $cities = $this->deliveryAddress->getAreasList($request->region);
        } catch (DeliveryApi $e) {
            return response()->json(['message' => $e->getMessage()], 501);
        }
        return response()->json([
            'content' => view('partials.order.form.item_list', ['items' => $cities])->render()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function city(Request $request)
    {
        try {
            $warehouses = $this->deliveryAddress->getWarehousesListInDetail($request->city, 25);
        } catch (DeliveryApi $e) {
            return response()->json(['message' => $e->getMessage()], 501);
        }
        return response()->json([
            'content' => view('partials.order.form.item_list', ['items' => $warehouses])->render()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function warehouse(Request $request)
    {
        try {
            $additionalServices = $this->deliveryServices
                ->setReceiveInfo($request->warehouse)
                ->getDopUslugiClassification();
            $tarif = $this->deliveryServices
                ->getTariffCategory();
            $deliveryScheme = $this->deliveryServices
                ->getDeliveryScheme();
            $warehouse = $this->deliveryAddress->getWarehousesInfo($request->warehouse);
            $insuranceCost = $this->deliveryServices
                ->getInsuranceCost();
        } catch (DeliveryApi $e) {
            return response()->json(['message' => $e->getMessage()], 501);
        }
        return response()->json([
            'content' => view(
                'partials.order.form.warehouse',
                [
                    'warehouse' => $warehouse,
                    'schemes' => $deliveryScheme,
                    'tarifs' => $tarif,
                    'additionalServices' => $additionalServices,
                    'insuranceCost' => $insuranceCost
                ]
            )->render()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function category(Request $request)
    {
        try {
            $categories = $this->deliveryServices->getCargoCategory($request->tarif);
        } catch (DeliveryApi $e) {
            return response()->json(['message' => $e->getMessage()], 501);
        }
        return response()->json(['content' => view('partials.order.form.categories', ['categories' => $categories])->render()]);
    }
}