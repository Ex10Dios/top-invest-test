<?php

namespace App\Http\Controllers;

use App\Candidate;
use Illuminate\Http\Request;

class CandidatesController extends Controller
{

    // Default validation rules
    protected $validationRules = [
        'name'           => ['required', 'string', 'max:255'],
        'family_name'    => ['required', 'string', 'max:255'],
        'email'          => ['required', 'string', 'email', 'max:255'],
        'phone'          => ['required', 'string', 'max:30'],
        'average_salary' => ['required', 'integer', 'min:0'],
        'gender'         => ['required', 'string', 'max:10'],
        'birth_date'     => ['required', 'date_format:Y-m-d'],
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    // Get page with table
    public function index(Request $request)
    {
        $search = $request->input('search');
        $data = Candidate::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%$search%")
                ->orWhere('family_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%");
        })->orderBy('id', 'asc')->paginate(10);

        return view('candidates.index', [
            'data'   => $data,
            'search' => $search
        ]);
    }

    // Export all data to CSV
    public function export()
    {
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=candidates' . date('Y-m-d') . '.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        $columns = [
            'Name',
            'Family Name',
            'Age',
            'E-Mail Address',
            'Phone',
            'Average Salary',
            'Gender',
            'Birth Date',
        ];

        $list = Candidate::all();

        $callback = function () use ($columns, $list) {
            $FH = fopen('php://output', 'w');
            fputcsv($FH, $columns);
            foreach ($list as $row) {
                $line = [
                    $row->name,
                    $row->family_name,
                    $row->age,
                    $row->email,
                    $row->phone,
                    $row->average_salary,
                    $row->gender,
                    $row->birth_date,
                ];
                fputcsv($FH, $line);
            }
            fclose($FH);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Get page with Add form
    public function add()
    {
        return view('candidates.form', ['candidate' => new Candidate()]);
    }

    // Store new item
    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules);
        $data = $request->all();
        Candidate::create([
            'name'           => $data['name'],
            'family_name'    => $data['family_name'],
            'email'          => $data['email'],
            'phone'          => $data['phone'],
            'average_salary' => $data['average_salary'],
            'gender'         => $data['gender'],
            'birth_date'     => $data['birth_date'],
        ]);
        return redirect()->route('candidates.index')->with('status', 'Successfully created');
    }

    // Get page with Edit form
    public function edit(Candidate $candidate)
    {
        return view('candidates.form', ['candidate' => $candidate]);
    }

    // Edit item data
    public function update(Request $request, Candidate $candidate)
    {
        $this->validate($request, $this->validationRules);
        $data = $request->all();
        $candidate->name = $data['name'];
        $candidate->family_name = $data['family_name'];
        $candidate->email = $data['email'];
        $candidate->phone = $data['phone'];
        $candidate->average_salary = $data['average_salary'];
        $candidate->gender = $data['gender'];
        $candidate->birth_date = $data['birth_date'];

        $candidate->save();
        return redirect()->route('candidates.index')->with('status', 'Successfully updated');
    }

    // Get data for Charts
    public function charts()
    {
        $candidates = Candidate::chartData();



        return view('candidates.charts', ['candidates' => $candidates->toArray()]);
    }
}
