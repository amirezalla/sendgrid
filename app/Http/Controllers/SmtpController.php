<?php

namespace App\Http\Controllers;

use App\Models\Smtp;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;

class SmtpController extends Controller
{
    //    
    public function list()
    {
        $smtpUsers = Smtp::paginate(10); // Paginate SMTP users, 10 per page
        return view('smtp.list', compact('smtpUsers'));
    }

    public function store(Request $request)
    {
            try {
                
                // The validated method returns only the validated data
                $validated = $request->validate([
                    'username' => 'required|string|max:255',
                    'password' => 'required|string|max:255',
                    'domain' => 'required|string|max:255',
                    'alert' => 'required|string|max:255',
                    'status' => 'required|string|max:255',
                    'expires_at' => 'nullable|date',
                ]);
                
        
                // Create the SMTP user
                $smtpUser = Smtp::create($validated);
        
                // If everything is fine, redirect back with a success message
                return redirect('/smtp/list')->with('success', 'SMTP user added successfully.');
            } catch (Exception $e) {
                // Log the error or handle it as needed
                dd($e);
                // Redirect back or to a specific page with an error message
                return redirect('/smtp/add')->with('error', 'Failed to add SMTP user.');
            }
    }


    public function edit($id)
    {

        $smtpUser = Smtp::findOrFail($id);
        return view('smtp.edit', compact('smtpUser'));
    }


    // Update the specified SMTP user in storage.
    public function update(Request $request)
    {
        // The validated method returns only the validated data
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'domain' => 'required|string|max:255',
            'alert' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'expires_at' => 'nullable|date',
        ]);
                        


        // Check if password is being updated
        if (empty($validated['password'])) {
            unset($validated['password']);        
        }

        $smtpUser = Smtp::findOrFail($request['id']);
        $smtpUser->update($validated);

        return redirect()->route('smtp.list')->with('success', 'SMTP User updated successfully.');
    }


    public function destroy($id)
    {
        $smtpUser = Smtp::findOrFail($id);
        $smtpUser->delete();

        return redirect()->route('smtp.list')->with('success', 'SMTP User deleted successfully.');
    }



}
