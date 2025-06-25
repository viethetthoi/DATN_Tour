<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Images;
use App\Models\admin\StartEndDate;
use App\Models\admin\TimeLine;
use App\Models\admin\Tour;
use Illuminate\Http\Request;

class TourAdminController extends Controller
{
    private $tour;
    private $image;
    private $timeline;
    private $date;
    public function __construct()
    {
        $this->tour = new Tour();
        $this->image = new Images();
        $this->timeline = new TimeLine();
        $this->date = new StartEndDate();
    }
    public function viewAddTour(){
        $title = 'Trang thêm tour';
        return view('admin.add-tours', compact('title'));
    }

    public function addTour(Request $request){
        $titleTour = $request->input('title');
        $destination = $request->input('destination');
        $domain = $request->input('domain');
        $description = $request->input('description');
        $time = $request->input('time');
        $data_tour = [
            'title' => $titleTour,
            'description' => $description,
            'destination' => $destination,
            'domain' => $domain,
            'time' =>$time
        ];
        $tourId = $this->tour->inserTour($data_tour);
        if($tourId != null){
            return view('admin.addImage' ,compact('tourId'));
        }
        return redirect()->back();
    }

    public function addImageTour(Request $request)
    {
        $tourId = $request->input('tourId');  
        $names = []; 
            if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
    
                $image->move(public_path('image'), $fileName);
                $names[] = $fileName;
            }
        }
        $checkInsert = $this->image->insertImage($names, $tourId);
        if($checkInsert == true){
            return view('admin.addTimeLine' ,compact('tourId'));
        }
        return redirect()->back();
        // dd($names, $tourId);
    }
    

    public function addTimeLineTour(Request $request){
        $tourId = $request->input('tourId');  
        $formData = [];
        $i = 1;
        while ($request->has("name_$i")) {
            $formData[] = [
                'name' => $request->input("name_$i"),
                'description' => $request->input("description_$i"),
            ];
            $i++;
        }
        $checkInsert = $this->timeline->insertTimeLine($formData, $tourId);
        if($checkInsert == true){
            return view('admin.addStartEndDate' ,compact('tourId'));
        }
        return redirect()->back();
        dd($formData);
    }

    public function addDateTour(Request $request){
        $tourId = $request->input('tourId');  
        $formSets = [];
        $count = 1;
        while ($request->has("start_date_$count")) {
            $formSets[] = [
                'start_date' => $request->input("start_date_$count"),
                'end_date'   => $request->input("end_date_$count"),
                'adult_price'=> $request->input("adult_price_$count"),
                'child_price'=> $request->input("child_price_$count"),
                'quantity'   => $request->input("quantity_$count"),
            ];
            $count++;
        }
        $checkInsert = $this->date->insertDate($formSets, $tourId);
        if($checkInsert == true){
            return redirect()->route('admin-list-tour') ->with('success', 'Đã thêm tour thành công!');
            // view('admin.addStartEnđate' ,compact('tourId'));
        }
        return redirect()->back()->with('error', 'Lỗi Không tìm thấy tour!');
        // dd($formSets);
    }

    public function viewListTour(){
        $tours = $this->tour->getAllTour();
        // dd($tours);
        return view('admin.list-tours', compact('tours'));
    }

    public function viewEditTour($tourId){
        $tour = $this->tour->getDetailTour($tourId);
        // dd($tour);
        return view('admin.edit-tour', compact('tour', 'tourId'));
    }

    public function viewEditImageTour($tourId){
        return view('admin.edit-image-tour', compact('tourId'));
    }

    public function viewEditTimeLineTour($tourId){
        $timelines = $this->timeline->getAllTimeLine($tourId); 
        // dd($timelines);
        return view('admin.edit-timeline-tour', compact('tourId', 'timelines'));
    }

    public function viewEditDateTour($tourId){
        $dates = $this->date->getAllDate($tourId);
        // dd($dates);
        return view('admin.edit-date-tour', compact('tourId', 'dates'));
    }

    public function EditTour(Request $request, $tourId){
        $titleTour = $request->input('title');
        $destination = $request->input('destination');
        $domain = $request->input('domain');
        $description = $request->input('description');

        $data_tour = [
            'tourId' => $tourId,
            'title' => $titleTour,
            'description' => $description,
            'destination' => $destination,
            'domain' => $domain
        ];
        // dd($data_tour);
        $checkTour = $this->tour->updateTour($data_tour);
        if ($checkTour >= 0) {
            return redirect()->route('admin-edit-tour', ['tourId' => $tourId])
            ->with('success', 'Cập nhật tour thành công!');
        
        } 
        return redirect()->back()->with('error', 'Không tìm thấy tour!');
    }

    public function editImageTour(Request $request, $tourId)
    {
        // $tourId = $request->input('tourId');  
        $names = []; 
            if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
    
                $image->move(public_path('image'), $fileName);
                $names[] = $fileName;
            }
        }
        $checkInsert = $this->image->insertImage($names, $tourId);
        if($checkInsert == true){
            return redirect()->route('admin-edit-submit-image-tour', ['tourId' => $tourId])
            ->with('success', 'Cập nhật hình ảnh thành công!');
        }
        return redirect()->back()->with('error', 'Không tìm thấy tour!');
    }

    public function editTimeLineTour(Request $request, $tourId){
        // $tourId = $request->input('tourId');  
        $formData = [];
        $i = 1;
        while ($request->has("name_$i")) {
            $formData[] = [
                'timeLineId' => $request->input("timeLineId_$i") ?? null,
                'name' => $request->input("name_$i"),
                'description' => $request->input("description_$i"),
            ];
            $i++;
        }
        
        $checkupdate = $this->timeline->updateTimeLine($formData, $tourId);
        if($checkupdate == true){
            return redirect()->route('admin-edit-submit-timeline-tour', ['tourId' => $tourId])
            ->with('success', 'Cập nhật hành trình thành công!');
        }
        return redirect()->back()->with('error', 'Không tìm thấy tour!');
        // dd($formData);
    }

    public function editDateTour(Request $request, $tourId){
        // $tourId = $request->input('tourId');  
        $formSets = [];
        $count = 1;
        while ($request->has("start_date_$count")) {
            $formSets[] = [
                'dateId' => $request->input("dateId_$count") ?? null,
                'start_date' => $request->input("start_date_$count"),
                'end_date'   => $request->input("end_date_$count"),
                'adult_price'=> $request->input("adult_price_$count"),
                'child_price'=> $request->input("child_price_$count"),
                'quantity'   => $request->input("quantity_$count"),
            ];
            $count++;
        }
        $check = $this->date->updateDate($formSets, $tourId);
        if($check == true){
            return redirect()->route('admin-edit-submit-date-tour', ['tourId' => $tourId])
            ->with('success', 'Cập nhật lịch trình thành công!');
        }
        return redirect()->back()->with('error', 'Không tìm thấy tour!');
        dd($formSets);
    }

    public function deleteTour($tourId) {
        $checkDele = $this->tour->deleteTour($tourId);

        if ($checkDele === 'n') {
            return redirect()->back()->with('error', 'Xóa tour thành công!');
        } elseif ($checkDele === 'y') {
            return redirect()->back()->with('success', 'Khôi phục tour thành công!');
        }

        return redirect()->back()->with('error', 'Không tìm thấy tour!');
    }

}
