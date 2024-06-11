const submitFilterForm = () => {
  refreshPage();
};

const refreshPage = () => {
  let position_name = $('input[name="position_name_input"]').val();
  let position_level = $('select[name="position_level_select"]').val();
  let employment_contract = $(
    'select[name="employment_contract_select"]'
  ).val();
  let employment_type = $('select[name="employment_type_select"]').val();
  let job_type = $('select[name="job_type_select"]').val();
  let salary_minimum = $('input[name="salary_minimum_input"]').val();
  let salary_maximum = $('input[name="salary_maximum_input"]').val();

  $.ajax({
    type: "GET",
    url: "utils/filterJobOferts.php",
    data: {
      position_name: `${position_name == undefined ? "" : position_name}`,
      position_level: `${position_level == undefined ? "" : position_level}`,
      employment_contract: `${
        employment_contract == undefined ? "" : employment_contract
      }`,
      employment_type: `${employment_type == undefined ? "" : employment_type}`,
      job_type: `${job_type == undefined ? "" : job_type}`,
      salary_minimum: `${salary_minimum == undefined ? "" : salary_minimum}`,
      salary_maximum: `${salary_maximum == undefined ? "" : salary_maximum}`,
    },
    success: function (result) {
      document.getElementById("filtered").innerHTML = result;
    },
  });
};
