<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CompanyProfile;
use App\Models\CandidateProfile;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Show candidate registration form
    public function showCandidateRegistrationForm()
    {
        return view('auth.register-candidate');
    }

    // Show recruiter registration form
    public function showRecruiterRegistrationForm()
    {
        return view('auth.register-recruiter');
    }

    // Register a new candidate
    public function registerCandidate(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->createCandidate($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    // Register a new recruiter
    public function registerRecruiter(Request $request)
    {
        $this->validatorRecruiter($request->all())->validate();

        event(new Registered($user = $this->createRecruiter($request->all())));

        // Don't login yet - pending approval
        return redirect()->route('login')
            ->with('status', 'Your recruiter account has been created and is pending approval. We will notify you once it is approved.');
    }

    // Validation rules for candidate
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);
    }

    // Validation rules for recruiter
    protected function validatorRecruiter(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name' => ['required', 'string', 'max:255'],
            'company_website' => ['nullable', 'url', 'max:255'],
            'company_description' => ['nullable', 'string'],
            'company_logo' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    // Create a new candidate
    protected function createCandidate(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'candidate',
            'is_approved' => true, // Set candidates as approved by default
        ]);

        // Create candidate profile
        $user->candidateProfile()->create([
            'phone' => $data['phone'] ?? null,
            'location' => $data['location'] ?? null,
            'skills' => '',
            'experience' => '',
            'education' => '',
        ]);

        return $user;
    }

    protected function createRecruiter(array $data)
    {
        $logoPath = null;
        if (isset($data['company_logo'])) {
            $logoPath = $data['company_logo']->store('company_logos', 'public');
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'recruiter',
            'is_active' => false, 
        ]);

        $user->companyProfile()->create([
            'company_name' => $data['company_name'],
            'website' => $data['company_website'] ?? null,
            'description' => $data['company_description'] ?? null,
            'logo' => $logoPath,
        ]);

        return $user;
    }
}