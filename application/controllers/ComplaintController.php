<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class ComplaintController extends RestController {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Complaints');
    }

    public function index_get($id = null)
    {
        if ($id == null) {
            $complaint = $this->Complaints->get()->result();
        } else {
            $complaint = $this->Complaints->get($id)->result();
        }

        if ($complaint == null) {
            $this->response([
                'status'    => false,
                'message'   => 'Complaint data is not found.'
            ], RestController::HTTP_NOT_FOUND);
        } else {
            $this->response([
                'status'    => true,
                'data'      => $complaint
            ], RestController::HTTP_OK);
        }
    }

    public function index_post()
    {
        $requestData = $this->post();
        $complaint = [
            'id'            => $requestData['id'],
            'id_complaint'  => FormatNo(ComplaintID()),
            'tanggal'       => date('Y-m-d H:i:s', time()),
            'toko'          => $requestData['toko'],
            'keluhan'       => $requestData['keluhan'],
            'catatan'       => $requestData['catatan']
        ];

        $save = $this->Complaints->save($complaint);
        if ($save > 0) {
            $this->response([
                'status'    => true,
                'message'   => 'Your complaint has been sent.'
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'status'    => true,
                'message'   => 'Failed to create. Data not valid.'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}