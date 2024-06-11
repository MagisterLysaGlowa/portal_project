<?php

class Company{
    public $company_name;
    public $company_location;
    public $company_address;
    public $company_description;
}

function InsertCompany($company){
    $connect = @new mysqli("localhost","root","","job_portal_db");
    $insert_query = "INSERT INTO company(company_name,company_address,company_location,company_description) 
        VALUES ('$company->company_name','$company->company_location','$company->company_address','$company->company_description')";
    $connect->query($insert_query);
    $company_id = $connect->insert_id;
    $connect->close();
    return $company_id;
}

function GetAllCompanies(){
    $connect = @new mysqli("localhost","root","","job_portal_db");
    $select_query = "SELECT * FROM company";
    $result = $connect->query($select_query);
    $connect->close();
    return $result;
}

function UpdateCompany($company_id,$company){
    $connect = @new mysqli("localhost","root","","job_portal_db");
    $update_query = "UPDATE company SET company_name='$company->company_name',
                                        company_address='$company->company_address',
                                        company_location='$company->company_location',
                                        company_description='$company->company_description' 
                                        WHERE company_id=$company_id";
    $connect->query($update_query);
    $connect->close();  
}

function GetCompany($company_id){
    $connect = @new mysqli("localhost","root","","job_portal_db");
    $select_query = "SELECT * FROM company WHERE company_id=$company_id";
    $result = $connect->query($select_query)->fetch_assoc();
    $connect->close();
    $company = new Company();
    $company->company_name = $result['company_name'];
    $company->company_address = $result['company_address'];
    $company->company_location = $result['company_location'];
    $company->company_description = $result['company_description'];
    return $company;
}

function DeleteCompany($company_id){
    $connect = @new mysqli("localhost","root","","job_portal_db");
    $delete_query = "DELETE FROM company WHERE compnay_id=$company_id";
    $connect->query($delete_query);
    $connect->close();  
}

?>