<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\City;
use App\Models\Province;
use App\Models\Provinci;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class CheckOngkirController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $user->province = $request->get('province_id');
        $user->city = $request->get('city_id');
        $user->kode_pos = $request->get('kode_pos');

        // ambil data provinsi berdasarkan id
        $province = Province::find($user->province_id);
        // ambil data kota berdasarkan id
        $city = City::find($user->city_id);

        $user->province = $province->name; // set nama provinsi
        $user->city = $city->name; // set nama kota

        $user->save();

        $categories = Category::all();

        return view('pages.checkout', [
            'user' => $user,
            'categories' => $categories
        ]);
    }

    public function account()
    {
        $user = Auth::user();
        // Memanggil function get_province
        $provinsi = $this->get_province();

        return view('pages.dashboard-account', [
            'user' => $user, 'provinsi' => $provinsi,
        ]);
    }
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */


    public function get_province()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 4645444ad5f4a08822b1e3c91778c02a"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            //ini kita decode data nya terlebih dahulu
            $response = json_decode($response, true);
            //ini untuk mengambil data provinsi yang ada di dalam rajaongkir resul
            $data_pengirim = $response['rajaongkir']['results'];
            return $data_pengirim;
        }
    }
    public function get_city($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?&province=$id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 4645444ad5f4a08822b1e3c91778c02a"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            $data_kota = $response['rajaongkir']['results'];
            return json_encode($data_kota);
        }
    }

    public function checkout()
    {
        $user = Auth::user();
        // Memanggil function get_province
        $provinsi = $this->get_province();
        // Mengambil data cart dari session
        $cartItems = Cart::with(['product.galleries', 'user'])->where('users_id', Auth::user()->id)->get();
        // Mengarah kepada file checkout.blade.php yang ada di view
        return view('pages.checkout', ['provinsi' => $provinsi, 'cartItems' => $cartItems, 'user' => $user]);
    }

    public function get_ongkir($origin, $destination, $weight, $courier)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$weight&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 4645444ad5f4a08822b1e3c91778c02a"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            $data_ongkir = $response['rajaongkir']['results'];
            return json_encode($data_ongkir);
        }
    }
}
