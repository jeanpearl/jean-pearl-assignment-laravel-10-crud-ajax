<?php

namespace App\Http\Controllers;

use App\Models\Perfume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerfumeController extends Controller {

    // set index page view
    public function index() {
        return view('index');
    }

    // handle fetch all eamployees ajax request
    public function read() {
        $perfs = Perfume::all();
        $output = '';
        if ($perfs->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Flavor</th>
                <th>Country</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($perfs as $perf) {
                $output .= '<tr>
                <td>' . $perf->id . '</td>
                <td><img src="files/public/images/' . $perf->perfume_image . '" width="50" class="img-thumbnail "></td>
                <td>' . $perf->perfume_name . '</td>
                <td>' . $perf->perfume_country . '</td>
                <td>' . $perf->perfume_price . '</td>
                <td>
                  <a href="#" id="' . $perf->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editPerfumeModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $perf->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No data!</h1>';
        }
    }

    // handle insert a new Perfume ajax request
    public function create(Request $request) {
        $file = $request->file('perfume_image');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $fileName, 'files');

        $perfData = ['perfume_name' => $request->perfume_name, 'perfume_flavor' => $request->perfume_flavor, 'perfume_country' => $request->perfume_country, 'perfume_price' => $request->perfume_price, 'perfume_image' => $fileName];
        Perfume::create($perfData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle edit an Perfume ajax request
    public function edit(Request $request) {
        $id = $request->id;
        $edit_perf = Perfume::find($id);
        return response()->json($edit_perf);
    }

    // handle update an Perfume ajax request
    public function update(Request $request) {
        $fileName = '';
        $update_perfume = Perfume::find($request->update_perfume_id);
        if ($request->hasFile('perfume_image')) {
            $file = $request->file('perfume_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName, 'files');
            if ($update_perfume->perfume_image) {
                Storage::delete('public/images/' . $perf->perfume_image);
            }
        } else {
            $fileName = $request->update_perfume_image;
        }

        $perfData = ['perfume_name' => $request->perfume_name, 'perfume_flavor' => $request->perfume_flavor, 'perfume_country' => $request->perfume_country, 'perfume_price' => $request->perfume_price, 'perfume_image' => $fileName];

        $update_perfume->update($perfData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle delete an Perfume ajax request
    public function delete(Request $request) {
        $id = $request->id;
        $delete_perfume = Perfume::find($id);
        if (Storage::delete('public/images/' . $delete_perfume->perfume_image)) {
            Perfume::destroy($id);
        }
    }
}