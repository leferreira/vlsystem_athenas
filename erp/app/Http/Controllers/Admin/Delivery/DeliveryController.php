<?php

namespace App\Http\Controllers\Admin\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Cidade;
use App\Models\Fornecedor;
use App\Models\ItemCompra;
use App\Models\NaturezaOperacao;
use App\Models\Produto;
use Illuminate\Http\Request;
use App\Models\DeliveryConfig;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados["categorias"] = Categoria::all();
        return view("Admin.Categoria.Index", $dados);
    }    
    
    public function config()
    {
        $dados["configdelivery"] = DeliveryConfig::first();
        return view("Admin.Delivery.Config", $dados);
    }
    
  
    
}
