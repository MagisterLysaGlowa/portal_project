<?php

class JobOfert{
    public $position_name;
    public $position_level;
    public $recruitment_end_date;
    public $employment_contract;
    public $employment_type;
    public $job_type;
    public $salary_minimum;
    public $salary_maximum;
    public $work_days;
    public $work_start_hour;
    public $work_end_hour;
    public $created_at;
    public $company_id;
}

function GetAllJobOferts(){
    $connect = @new mysqli("localhost","root","","job_portal_db");
    $select_query = "SELECT * FROM job_ofert";
    $result = $connect->query($select_query);
    $connect->close();
    return $result;
}

function InsertJobOfert($job_ofert){
    $connect = @new mysqli("localhost","root","","job_portal_db");
    $insert_query = "INSERT INTO job_ofert (position_name,
                                          position_level,
                                          recruitment_end_date,
                                          employment_contract,
                                          employment_type,
                                          job_type,
                                          salary_minimum,
                                          salary_maximum, 
                                          work_days,
                                          work_start_hour,
                                          work_end_hour,
                                          created_at,
                                          company_id) 
                                          VALUES ('$job_ofert->position_name',
                                                  '$job_ofert->position_level',
                                                  '$job_ofert->recruitment_end_date',
                                                  '$job_ofert->employment_contract',
                                                  '$job_ofert->employment_type',
                                                  '$job_ofert->job_type',
                                                  '$job_ofert->salary_minimum',
                                                  '$job_ofert->salary_maximum',
                                                  '$job_ofert->work_days',
                                                  '$job_ofert->work_start_hour',
                                                  '$job_ofert->work_end_hour',
                                                  '$job_ofert->created_at',
                                                  '$job_ofert->company_id')";
    $connect->query($insert_query);
    $job_ofert_id = $connect->insert_id;
    $connect->close();
    return $job_ofert_id;
}

function UpdateJobOfert($job_ofert_id,$job_ofert){
    $connect = @new mysqli("localhost","root","","job_portal_db");
    $update_query = "UPDATE job_ofert SET position_name='$job_ofert->position_name',
                                        position_level='$job_ofert->position_level',
                                        recruitment_end_date='$job_ofert->recruitment_end_date',
                                        employment_contract='$job_ofert->employment_contract',
                                        employment_type='$job_ofert->employment_type', 
                                        job_type='$job_ofert->job_type' ,
                                        salary_minimum='$job_ofert->salary_minimum' ,
                                        salary_maximum='$job_ofert->salary_maximum' ,
                                        work_days='$job_ofert->work_days' ,
                                        work_start_hour='$job_ofert->work_start_hour' ,
                                        work_end_hour='$job_ofert->work_end_hour' ,
                                        created_at='$job_ofert->created_at' ,
                                        company_id='$job_ofert->company_id'
                                        WHERE job_ofert_id=$job_ofert_id";
    $connect->query($update_query);
    $connect->close();  
}

function GetJobOfert($job_ofert_id){
    $connect = @new mysqli("localhost","root","","job_portal_db");
    $select_query = "SELECT * FROM job_ofert WHERE job_ofert_id=$job_ofert_id";
    $result = $connect->query($select_query)->fetch_assoc();
    $connect->close();
    $job_ofert = new JobOfert();
    $job_ofert->position_name = $result['position_name'];
    $job_ofert->position_level = $result['position_level'];
    $job_ofert->recruitment_end_date = $result['recruitment_end_date'];
    $job_ofert->employment_contract = $result['employment_contract'];
    $job_ofert->employment_type = $result['employment_type'];
    $job_ofert->job_type = $result['job_type'];
    $job_ofert->salary_minimum = $result['salary_minimum'];
    $job_ofert->salary_maximum = $result['salary_maximum'];
    $job_ofert->work_days = $result['work_days'];
    $job_ofert->work_start_hour = $result['work_start_hour'];
    $job_ofert->work_end_hour = $result['work_end_hour'];
    $job_ofert->created_at = $result['created_at'];
    $job_ofert->company_id = $result['company_id'];
    return $job_ofert;
}

?>