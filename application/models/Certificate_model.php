<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Certificate_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getList()
    {
        $this->db->select('certificates_templete.*,branch.name as branchname');
        $this->db->from('certificates_templete');
        $this->db->join('branch', 'branch.id = certificates_templete.branch_id', 'left');
        if (!is_superadmin_loggedin()) {
            $this->db->where('certificates_templete.branch_id', get_loggedin_branch_id());
        }
        $this->db->order_by('certificates_templete.id', 'ASC');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function save($data)
    {
        $background_file = '';
        $oldBackground_file = $this->input->post('old_background_file');
        if (isset($_FILES["background_file"]) && !empty($_FILES['background_file']['name'])) {
            $config['upload_path'] = './uploads/certificate/';
            $config['allowed_types'] = 'jpg|png';
            $config['overwrite'] = false;
            $this->upload->initialize($config);
            if ($this->upload->do_upload("background_file")) {
                // need to unlink previous photo
                if (!empty($oldBackground_file)) {
                    $unlink_path = 'uploads/certificate/' . $oldBackground_file;
                    if (file_exists($unlink_path)) {
                        @unlink($unlink_path);
                    }
                }
                $background_file = $this->upload->data('file_name');
            }
        } else {
            if (!empty($oldBackground_file)) {
                $background_file = $oldBackground_file;
            }
        }

        $logo_file = '';
        $oldLogo_file = $this->input->post('old_logo_file');
        if (isset($_FILES["logo_file"]) && !empty($_FILES['logo_file']['name'])) {
            $config['upload_path'] = './uploads/certificate/';
            $config['allowed_types'] = 'jpg|png';
            $config['overwrite'] = false;
            $this->upload->initialize($config);
            if ($this->upload->do_upload("logo_file")) {
                // need to unlink previous photo
                if (!empty($oldLogo_file)) {
                    $unlink_path = 'uploads/certificate/' . $oldLogo_file;
                    if (file_exists($unlink_path)) {
                        @unlink($unlink_path);
                    }
                }
                $logo_file = $this->upload->data('file_name');
            }
        } else {
            if (!empty($oldLogo_file)) {
                $logo_file = $oldLogo_file;
            }
        }

        $signature_file = '';
        $oldSignature_file = $this->input->post('old_signature_file');
        if (isset($_FILES["signature_file"]) && !empty($_FILES['signature_file']['name'])) {
            $config['upload_path'] = './uploads/certificate/';
            $config['allowed_types'] = 'jpg|png';
            $config['overwrite'] = false;
            $this->upload->initialize($config);
            if ($this->upload->do_upload("signature_file")) {
                // need to unlink previous photo
                if (!empty($oldSignature_file)) {
                    $unlink_path = 'uploads/certificate/' . $oldSignature_file;
                    if (file_exists($unlink_path)) {
                        @unlink($unlink_path);
                    }
                }
                $signature_file = $this->upload->data('file_name');
            }
        } else {
            if (!empty($oldSignature_file)) {
                $signature_file = $oldSignature_file;
            }
        }

        if ($data['user_type'] == 1) {
            $qrCode = $data['stu_qr_code'];
        } else {
            $qrCode = $data['emp_qr_code'];
        }

        $arrayLive = array(
            'branch_id' => $this->application_model->get_branch_id(),
            'name' => $data['certificate_name'],
            'user_type' => $data['user_type'],
            'page_layout' => $data['page_layout'],
            'qr_code' => $qrCode,
            'photo_style' => $data['photo_style'],
            'photo_size' => empty($data['photo_size']) ? 100 : $data['photo_size'],
            'top_space' => empty($data['top_space']) ? 0 : $data['top_space'],
            'bottom_space' => empty($data['bottom_space']) ? 0 : $data['bottom_space'],
            'right_space' => empty($data['right_space']) ? 0 : $data['right_space'],
            'left_space' => empty($data['left_space']) ? 0 : $data['left_space'],
            'background' => $background_file,
            'logo' => $logo_file,
            'signature' => $signature_file,
            'content' => $this->input->post('content', false),
        );
        if (!isset($data['certificate_id'])) {
            $this->db->insert('certificates_templete', $arrayLive);
        } else {
            $this->db->where('id', $data['certificate_id']);
            $this->db->update('certificates_templete', $arrayLive);
        }
    }

    public function tagsList($roleID = "")
    {
        $arrayTags = array();
        $arrayTags[] = '{name}';
        $arrayTags[] = '{gender}';
        if ($roleID == 1) {
            $arrayTags[] = '{father_name}';
            $arrayTags[] = '{mother_name}';
            $arrayTags[] = '{student_photo}';
            $arrayTags[] = '{register_no}';
            $arrayTags[] = '{roll}';
            $arrayTags[] = '{admission_date}';
            $arrayTags[] = '{class}';
            $arrayTags[] = '{section}';
            $arrayTags[] = '{category}';
            $arrayTags[] = '{caste}';
        }
        if ($roleID == 2) {
            $arrayTags[] = '{staff_photo}';
            $arrayTags[] = '{staff_id}';
            $arrayTags[] = '{joining_date}';
            $arrayTags[] = '{designation}';
            $arrayTags[] = '{department}';
            $arrayTags[] = '{qualification}';
            $arrayTags[] = '{total_experience}';
        }
        $arrayTags[] = '{religion}';
        $arrayTags[] = '{blood_group}';
        $arrayTags[] = '{birthday}';
        $arrayTags[] = '{email}';
        $arrayTags[] = '{mobileno}';
        $arrayTags[] = '{present_address}';
        $arrayTags[] = '{permanent_address}';
        $arrayTags[] = '{logo}';
        $arrayTags[] = '{signature}';
        $arrayTags[] = '{qr_code}';
        $arrayTags[] = '{institute_name}';
        $arrayTags[] = '{institute_email}';
        $arrayTags[] = '{institute_address}';
        $arrayTags[] = '{institute_mobile_no}';
        $arrayTags[] = '{print_date}';
        return $arrayTags;
    }

    public function tagsReplace($roleID, $userID, $templete, $print_date)
    {
        $body = $templete['content'];
        $photo_size = $templete['photo_size'];
        $photo_style = $templete['photo_style'];
        $tags = $this->tagsList($roleID);
        if ($roleID == 1) {
            $userDetails = $this->getStudent($userID);
        } else if ($roleID == 2) {
            $userDetails = $this->getStaff($userID);
        }
        $arr = array('{', '}');
        foreach ($tags as $tag) {
            $field = str_replace($arr, '', $tag);
            if ($roleID == 1) {
                if ($field == 'student_photo') {
                    $photo = '<img class="' . ($photo_style == 1 ? '' : 'rounded') . '" src="' . get_image_url('student', $userDetails['photo']) . '" width="' . $photo_size . '">';
                    $body = str_replace($tag, $photo, $body);
                } else if ($field == 'logo') {
                    if (!empty($templete['logo'])) {
                        $logo_ph = '<img src="' . base_url('uploads/certificate/' . $templete['logo']) . '">';
                        $body = str_replace($tag, $logo_ph, $body);
                    }
                } else if ($field == 'signature') {
                    if (!empty($templete['signature'])) {
                        $signature_ph = '<img src="' . base_url('uploads/certificate/' . $templete['signature']) . '">';
                        $body = str_replace($tag, $signature_ph, $body);
                    }
                } else if ($field == 'qr_code') {
                    if (!empty($templete['qr_code'])) {
                        $qr_code = $templete['qr_code'];
                        $params['savename'] = 'uploads/qr_code/stu_' . $userDetails['id'] . '.png';
                        $params['level'] = 'M';
                        $params['size'] = 4;
                        $params['data'] = ucfirst($qr_code) . " - " . $userDetails[$qr_code];
                        $qrCode = $this->ciqrcode->generate($params);
                        $photo = '<img src="' . base_url($qrCode) . '">';
                        $body = str_replace($tag, $photo, $body);
                    }
                } else if ($field == 'present_address') {
                    $body = str_replace($tag, $userDetails['current_address'], $body);
                } else if ($field == 'print_date') {
                    $body = str_replace($tag, _d($print_date), $body);
                } else {
                    $body = str_replace($tag, $userDetails[$field], $body);
                }
            }

            if ($roleID == 2) {
                if ($field == 'staff_photo') {
                    $photo = '<img class="' . ($photo_style == 1 ? '' : 'rounded') . '" src="' . get_image_url('staff', $userDetails['photo']) . '" width="' . $photo_size . '">';
                    $body = str_replace($tag, $photo, $body);
                } else if ($field == 'logo') {
                    if (!empty($templete['logo'])) {
                        $logo_ph = '<img src="' . base_url('uploads/certificate/' . $templete['logo']) . '">';
                        $body = str_replace($tag, $logo_ph, $body);
                    }
                } else if ($field == 'signature') {
                    if (!empty($templete['signature'])) {
                        $signature_ph = '<img src="' . base_url('uploads/certificate/' . $templete['signature']) . '">';
                        $body = str_replace($tag, $signature_ph, $body);
                    }
                } else if ($field == 'print_date') {
                    $body = str_replace($tag, _d($print_date), $body);
                } else if ($field == 'qr_code') {
                    if (!empty($templete['qr_code'])) {
                        $qr_code = $templete['qr_code'];
                        $params['savename'] = 'uploads/qr_code/sta_' . $userDetails['id'] . '.png';
                        $params['level'] = 'M';
                        $params['size'] = 4;
                        $params['data'] = ucfirst($qr_code) . " - " . $userDetails[$qr_code];
                        $qrCode = $this->ciqrcode->generate($params);
                        $photo = '<img src="' . base_url($qrCode) . '">';
                        $body = str_replace($tag, $photo, $body);
                    }
                } else if ($field == 'gender') {
                    $body = str_replace($tag, $userDetails['sex'], $body);
                } else {
                    $body = str_replace($tag, $userDetails[$field], $body);
                }
            }
        }
        return $body;
    }

    public function getStudent($id)
    {
        $this->db->select('s.*,CONCAT_WS(" ",s.first_name, s.last_name) as name,e.roll,e.branch_id,e.session_id,c.name as class,se.name as section,sc.name as category,p.father_name,p.mother_name,br.name as institute_name,br.email as institute_email,br.address as institute_address,br.mobileno as institute_mobile_no');
        $this->db->from('enroll as e');
        $this->db->join('student as s', 'e.student_id = s.id', 'left');
        $this->db->join('class as c', 'e.class_id = c.id', 'left');
        $this->db->join('section as se', 'e.section_id = se.id', 'left');
        $this->db->join('student_category as sc', 's.category_id=sc.id', 'left');
        $this->db->join('parent as p', 'p.id=s.parent_id', 'left');
        $this->db->join('branch as br', 'br.id = e.branch_id', 'left');
        $this->db->where('s.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getStaff($id)
    {
        $this->db->select('s.*,s.department as deid,s.designation as desid,staff_department.name as department,staff_designation.name as designation,br.name as institute_name,br.email as institute_email,br.address as institute_address,br.mobileno as institute_mobile_no');
        $this->db->from('staff as s');
        $this->db->join('staff_department', 'staff_department.id = s.department', 'left');
        $this->db->join('staff_designation', 'staff_designation.id = s.designation', 'left');
        $this->db->join('branch as br', 'br.id = s.branch_id', 'left');
        $this->db->where('s.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
}
