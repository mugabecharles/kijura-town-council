<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.form', ['slider' => new Slider]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'subtitle'       => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'image'          => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'image_alt'      => 'nullable|string|max:255',
            'button_text'    => 'nullable|string|max:100',
            'button_url'     => 'nullable|string|max:500',
            'button_target'  => 'nullable|in:_self,_blank',
            'overlay_color'  => 'nullable|string|max:50',
            'text_color'     => 'nullable|string|max:50',
            'duration'       => 'nullable|integer|min:1000',
            'sort_order'     => 'nullable|integer',
            'is_active'      => 'nullable|boolean',
            'starts_at'      => 'nullable|date',
            'ends_at'        => 'nullable|date|after:starts_at',
        ]);

        $data['image']      = $request->file('image')->store('sliders', 'public');
        $data['is_active']  = $request->boolean('is_active');
        $data['created_by'] = auth()->id();

        $slider = Slider::create($data);
        AuditLog::record('create', "Created slider: {$slider->title}", $slider);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.form', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'subtitle'      => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'image_alt'     => 'nullable|string|max:255',
            'button_text'   => 'nullable|string|max:100',
            'button_url'    => 'nullable|string|max:500',
            'button_target' => 'nullable|in:_self,_blank',
            'overlay_color' => 'nullable|string|max:50',
            'text_color'    => 'nullable|string|max:50',
            'duration'      => 'nullable|integer|min:1000',
            'sort_order'    => 'nullable|integer',
            'is_active'     => 'nullable|boolean',
            'starts_at'     => 'nullable|date',
            'ends_at'       => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($slider->image);
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');
        $slider->update($data);
        AuditLog::record('update', "Updated slider: {$slider->title}", $slider);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        Storage::disk('public')->delete($slider->image);
        AuditLog::record('delete', "Deleted slider: {$slider->title}", $slider);
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->input('order', []) as $item) {
            Slider::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }
        return response()->json(['success' => true]);
    }
}
