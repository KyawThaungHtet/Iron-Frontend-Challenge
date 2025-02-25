<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function signup()
    {
        $email = $this->request->getPost('email');
        $filePath = APPPATH . 'Database/data.json';

        if ($email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Invalid email address']);
            }

            $data = json_decode(file_get_contents($filePath), true);

            if (in_array($email, $data['users'])) {
                return $this->response->setJSON(['success' => false, 'message' => 'You have already signed up!']);
            }

            $data['users'][] = $email;  
            file_put_contents($filePath, json_encode($data));

            return $this->response->setJSON(['success' => true, 'message' => 'Thank you for signing up!']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'No email provided']);
    }
}
