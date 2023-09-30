<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Exam_progress_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function ordinal($number)
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number . 'th';
        } else {
            return $number . $ends[$number % 10];
        }
    }

    public function getExamTotalMark($studentID, $sessionID, $subjectID = '', $examID = '')
    {
        $this->db->select('m.mark as get_mark,IFNULL(m.absent, 0) as get_abs,te.mark_distribution');
        $this->db->from('mark as m');
        $this->db->join('timetable_exam as te', 'te.exam_id = m.exam_id and te.class_id = m.class_id and te.section_id = m.section_id and te.subject_id = m.subject_id', 'left');
        $this->db->join('exam as e', 'e.id = m.exam_id', 'inner');
        $this->db->where('m.exam_id', $examID);
        $this->db->where('m.student_id', $studentID);
        $this->db->where('m.session_id', $sessionID);
        $this->db->where('m.subject_id', $subjectID);
        $getMarksList = $this->db->get()->row_array();
        $grand_obtain_marks = 0;
        $grand_full_marks = 0;
        if (!empty($getMarksList)) {
            $fullMarkDistribution = json_decode($getMarksList['mark_distribution'], true);
            $obtainedMark = json_decode($getMarksList['get_mark'], true);
            $total_obtain_marks = 0;
            $total_full_marks = 0;
            foreach ($fullMarkDistribution as $i => $val) {
                $obtained_mark = floatval($obtainedMark[$i]);
                $fullMark = floatval($val['full_mark']);
                if ($getMarksList['get_abs'] != 'on') {
                    $total_full_marks += $fullMark;
                    $total_obtain_marks += $obtained_mark;
                }
            }
            $grand_obtain_marks += $total_obtain_marks;
            $grand_full_marks += $total_full_marks;
        }
        if (!empty($grand_obtain_marks) || !empty($grand_full_marks)) {
            return ['grand_obtain_marks' => $grand_obtain_marks, 'grand_full_marks' => $grand_full_marks];
        } else {
            return ['grand_obtain_marks' => 0, 'grand_full_marks' => 0];
        }
    }

    public function getClassAverage($examID, $sessionID, $subjectID = '')
    {
        $this->db->select('m.mark as get_mark,IFNULL(m.absent, 0) as get_abs');
        $this->db->from('mark as m');
        if (is_array($examID)) {
            $this->db->where_in('m.exam_id', $examID);
        } else {
            $this->db->where('m.exam_id', $examID);
        }
        $this->db->where('m.session_id', $sessionID);
        $this->db->where('m.subject_id', $subjectID);
        $getMarksList = $this->db->get()->result_array();
        $count = count($getMarksList);
        $grand_obtain_marks = 0;
        foreach ($getMarksList as $row) {
            $obtainedMark = json_decode($row['get_mark'], true);
            $total_obtain_marks = 0;
            foreach ($obtainedMark as $i => $val) {
                $obtained_mark = floatval($obtainedMark[$i]);
                if ($row['get_abs'] != 'on') {
                    $total_obtain_marks += $obtained_mark;
                }
            }
            $grand_obtain_marks += $total_obtain_marks;
        }
        if (!empty($grand_obtain_marks)) {
            $grand_percentage = $grand_obtain_marks / $count;
        } else {
            $grand_percentage = 0;
        }

        $cumulative = number_format($grand_percentage, 2, '.', '');
        return $cumulative . "";
    }

    public function getSubjectPosition($classID = '', $sectionID = '', $examID = [], $sessionID = '', $subjectID = '', $mark = 0)
    {
        $this->db->select('student_id as id');
        $this->db->where('class_id', $classID);
        $this->db->where('section_id', $sectionID);
        $this->db->where('session_id', $sessionID);
        $enroll = $this->db->get('enroll')->result();
        $grand_obtain_marks = [];
        foreach ($enroll as $key => $value) {
            $this->db->select('m.mark as get_mark,IFNULL(m.absent, 0) as get_abs');
            $this->db->from('mark as m');
            $this->db->where_in('m.exam_id', $examID);
            $this->db->where('m.student_id', $value->id);
            $this->db->where('m.session_id', $sessionID);
            $this->db->where('m.subject_id', $subjectID);
            $getMarksList = $this->db->get()->result_array();
            $obtain_marks = 0;
            foreach ($getMarksList as $row) {
                $obtainedMark = json_decode($row['get_mark'], true);
                $total_obtain_marks = 0;
                foreach ($obtainedMark as $i => $val) {
                    $obtained_mark = floatval($obtainedMark[$i]);
                    if ($row['get_abs'] != 'on') {
                        $obtain_marks += $obtained_mark;
                    }
                }
            }
            $grand_obtain_marks[] = $obtain_marks;
        }
        array_multisort($grand_obtain_marks, SORT_DESC, $grand_obtain_marks);
        $f = array_keys($grand_obtain_marks, $mark);
        if (empty($f)) {
            return 'N/A';
        } else {
            return $this->ordinal($f[0] + 1);
        }
    }

    public function get_grade($mark, $branch_id)
    {
        $this->db->where('branch_id', $branch_id);
        $query = $this->db->get('grade');
        $grades = $query->result_array();
        foreach ($grades as $row) {
            if ($mark >= $row['lower_mark'] && $mark <= $row['upper_mark']) {
                return $row;
            }
        }
    }

    public function getStudentReportCard($studentID, $sessionID)
    {
        $result = array();
        $this->db->select('enroll.roll,enroll.class_id,enroll.section_id,enroll.branch_id,student.*,c.name as class_name,se.name as section_name,IFNULL(parent.father_name,"N/A") as father_name,IFNULL(parent.mother_name,"N/A") as mother_name');
        $this->db->from('enroll');
        $this->db->join('student', 'student.id = enroll.student_id', 'inner');
        $this->db->join('class as c', 'c.id = enroll.class_id', 'left');
        $this->db->join('section as se', 'se.id = enroll.section_id', 'left');
        $this->db->join('parent', 'parent.id = student.parent_id', 'left');
        $this->db->where('enroll.student_id', $studentID);
        $this->db->where('enroll.session_id', $sessionID);
        $result['student'] = $this->db->get()->row_array();
        return $result;
    }
}
