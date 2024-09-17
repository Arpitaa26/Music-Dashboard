<?php

class Calendar extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("calendar_model");
    }

    public function index()
    {
        try {
            $this->http->auth(["get"], "ADMIN");
            view("calendar/index", null, "Portal | Batch");
        } catch (\Throwable $th) {
            //throw $th;
            redirect(base_url('calendar'), 'refresh');
        }
    }



    public function get_eventsss()
    {
        $start = strtotime($this->input->get("start"));
        $end = strtotime($this->input->get("end"));

        $startdt = new DateTime('now'); // setup a local datetime
        $startdt->setTimestamp($start); // Set the date based on timestamp

        $start_format = $startdt->format('Y-m-d H:i:s');

        $enddt = new DateTime('now'); // setup a local datetime
        $enddt->setTimestamp($end); // Set the date based on timestamp
        $end_format = $enddt->format('Y-m-d H:i:s');

        $events = $this->calendar_model->get_events($start_format, $end_format);
        $str = $this->db->last_query();
        pp($str);
    }
    public function get_events()
    {




        // Load the database library (if not autoloaded)

        // Our Start and End Dates
        //  $start = strtotime($this->input->get("start"));
        //  $end =strtotime( $this->input->get("end"));
        $start = strtotime('2023-08-26 00:00:00');
        $end = strtotime('2023-08-30 05:30:00');

        $startdt = new DateTime('now'); // setup a local datetime
        $startdt->setTimestamp($start); // Set the date based on timestamp

        $start_format = $startdt->format('Y-m-d H:i:s');

        $enddt = new DateTime('now'); // setup a local datetime
        $enddt->setTimestamp($end); // Set the date based on timestamp
        $end_format = $enddt->format('Y-m-d H:i:s');

        $events = $this->calendar_model->get_events($start_format, $end_format);

        $data_events = array();

        foreach ($events as $r) {

            $data_events[] = array(
                "id" => $r->ID,
                "title" => $r->title,
                "description" => $r->description,
                "end" => $r->end_date,
                "start" => $r->start_date,
                "backgroundColor" => $r->bg_color,
                "borderColor" => $r->text_color
            );
        }

        echo json_encode($data_events);
        exit();
    }

    public function get_class()
    {




        // Load the database library (if not autoloaded)

        // Our Start and End Dates
        //  $start = strtotime($this->input->get("start"));
        //  $end =strtotime( $this->input->get("end"));
        $start = strtotime('2023-08-26 00:00:00');
        $end = strtotime('2023-08-30 05:30:00');

        $startdt = new DateTime('now'); // setup a local datetime
        $startdt->setTimestamp($start); // Set the date based on timestamp

        $start_format = $startdt->format('Y-m-d H:i:s');

        $enddt = new DateTime('now'); // setup a local datetime
        $enddt->setTimestamp($end); // Set the date based on timestamp
        $end_format = $enddt->format('Y-m-d H:i:s');

        $events = $this->calendar_model->get_class($start_format, $end_format);

        $data_events = array();

        foreach ($events as $r) {

            $data_events[] = array(
                "id" => $r->id,
                "title" => $r->status,
                "description" => $r->module_id,
                "end" => $r->end_time,
                "start" => $r->start_time

            );
        }
        //pp($data_events);
        echo json_encode($data_events);
        exit();
    }
    public function get_availability()
    {
        $start = strtotime('2023-08-26 00:00:00');
        $end = strtotime('2023-08-30 05:30:00');

        $startdt = new DateTime('now'); // setup a local datetime
        $startdt->setTimestamp($start); // Set the date based on timestamp

        $start_format = $startdt->format('Y-m-d H:i:s');

        $enddt = new DateTime('now'); // setup a local datetime
        $enddt->setTimestamp($end); // Set the date based on timestamp
        $end_format = $enddt->format('Y-m-d H:i:s');

        $events = $this->calendar_model->get_availability($start_format, $end_format);

        $data_events = array();

        foreach ($events as $r) {

            $data_events[] = array(
                "id" => $r->id,
                "title" => $r->user_fullname,
                "description" => $r->class_id,
                "end" => $r->to,
                "start" => $r->from

            );
        };
        echo json_encode($data_events);
        exit();
    }
    //

    public function add_events()
    {
        /* Our calendar data */
        $name = $this->input->post("title", TRUE);
        $desc = $this->input->post("desc", TRUE);
        $start_date = $this->input->post("start", TRUE);
        $end_date = $this->input->post("end", TRUE);

        if (!empty($start_date)) {
            $sd = DateTime::createFromFormat("Y/m/d H:i", $start_date);
            $start_date = $sd->format('Y-m-d H:i:s');
            $start_date_timestamp = $sd->getTimestamp();
        } else {
            $start_date = date("Y-m-d H:i:s", time());
            $start_date_timestamp = time();
        }

        if (!empty($end_date)) {
            $ed = DateTime::createFromFormat("Y/m/d H:i", $end_date);
            $end_date = $ed->format('Y-m-d H:i:s');
            $end_date_timestamp = $ed->getTimestamp();
        } else {
            $end_date = date("Y-m-d H:i:s", time());
            $end_date_timestamp = time();
        }

        $this->calendar_model->add_event(
            array(
                "title" => $name,
                "description" => $desc,
                "start_date" => $start_date,
                "end_date" => $end_date
            )
        );

        redirect(site_url("calendar"));
    }
    public function add_event()
    {

        $data = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('desc'),
            'start_date' => $this->input->post('start'),
            'end_date' => $this->input->post('end')
        );

        $this->calendar_model->add_event($data);
    }
    public function edit_event()
    {
        $eventid = intval($this->input->post("eventid"));
        $event = $this->calendar_model->get_event($eventid);
        if ($event->num_rows() == 0) {
            echo "Invalid Event";
            exit();
        }

        $event->row();

        /* Our calendar data */
        $name = $this->input->post("name");
        $desc = $this->input->post("description") ? $this->input->post("description") : 'ghfg';
        $start_date = $this->input->post("start_date");
        $end_date = $this->input->post("end_date");
        $delete = intval($this->input->post("delete"));

        if (!$delete) {

            //   if(!empty($start_date)) {
            //         $sd = DateTime::createFromFormat("Y/m/d H:i", $start_date);
            //         $start_date = $sd->format('Y-m-d H:i:s');
            //         $start_date_timestamp = $sd->getTimestamp();
            //   } else {
            //         $start_date = date("Y-m-d H:i:s", time());
            //         $start_date_timestamp = time();
            //   }

            //   if(!empty($end_date)) {
            //         $ed = DateTime::createFromFormat("Y/m/d H:i", $end_date);
            //         $end_date = $ed->format('Y-m-d H:i:s');
            //         $end_date_timestamp = $ed->getTimestamp();
            //   } else {
            //         $end_date = date("Y-m-d H:i:s", time());
            //         $end_date_timestamp = time();
            //   }

            $this->calendar_model->update_event(
                $eventid,
                array(
                    "title" => $name,
                    "description" => $desc,
                    "start_date" => $start_date,
                    "end_date" => $end_date,
                )
            );
        } else {
            $this->calendar_model->delete_event($eventid);
        }

        redirect(site_url());
    }
}
