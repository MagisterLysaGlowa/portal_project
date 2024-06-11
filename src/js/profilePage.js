const profile_page_inputs = document.querySelectorAll(".profile-input-group");
let edit_mode = true;

const handleProfileEditClick = () => {
  edit_mode = !edit_mode;
  if (edit_mode) {
    profile_page_inputs.forEach((item) => {
      item.removeAttribute("disabled");
    });

    document.getElementById("profile_button").classList.add("bg-red-800");
    document.getElementById("profile_button").classList.remove("bg-green-800");
    document.getElementById("profile_button").innerText = "Zakończ edytowanie";
  } else {
    profile_page_inputs.forEach((item) => {
      item.setAttribute("disabled", "true");
    });
    document.getElementById("profile_button").classList.remove("bg-red-800");
    document.getElementById("profile_button").classList.add("bg-green-800");
    document.getElementById("profile_button").innerText = "Edytuj";

    let user_id = $('input[name="user_id"]').val();
    let name = $('input[name="name"]').val();
    let surname = $('input[name="surname"]').val();
    let email = $('input[name="email"]').val();
    let phone = $('input[name="phone"]').val();
    let location = $('input[name="location"]').val();
    let birthday = $('input[name="birthday"]').val();

    $.ajax({
      type: "GET",
      url: "utils/updateProfile.php",
      data: {
        user_id: `${user_id}`,
        name: `${name}`,
        surname: `${surname}`,
        email: `${email}`,
        phone: `${phone}`,
        location: `${location}`,
        birthday: `${birthday}`,
      },
      success: function (result) {},
    });
  }
};

const handleEducationInsert = () => {
  let school_name = $('input[name="school_name"]').val();
  let school_level = $('select[name="school_level"]').val();
  let school_type = $('input[name="school_type"]').val();
  let school_start_date = $('input[name="school_start_date"]').val();
  let school_end_date = $('input[name="school_end_date"]').val();
  let user_id = $('input[name="user_id"]').val();

  //clear inputs
  $('input[name="school_name"]').val("");
  $('select[name="school_level"]').val("");
  $('input[name="school_type"]').val("");
  $('input[name="school_start_date"]').val("");
  $('input[name="school_end_date"]').val("");

  $.ajax({
    type: "GET",
    url: "utils/insertEducation.php",
    data: {
      user_id: `${user_id}`,
      school_name: `${school_name}`,
      school_level: `${school_level}`,
      school_type: `${school_type}`,
      school_start_date: `${school_start_date}`,
      school_end_date: `${school_end_date}`,
    },
    success: function (result) {
      document.getElementById("educations-wrapper").innerHTML = result;
    },
  });
};

const handleEducationDeleteClick = (education_id) => {
  let user_id = $('input[name="user_id"]').val();
  $.ajax({
    type: "GET",
    url: "utils/removeEducation.php",
    data: {
      user_id: `${user_id}`,
      education_id: `${education_id}`,
    },
    success: function (result) {
      document.getElementById("educations-wrapper").innerHTML = result;
    },
  });
};

const handleExperienceInsert = () => {
  let position_name = $('input[name="position_name"]').val();
  let company_name = $('input[name="company_name"]').val();
  let work_start_date = $('input[name="work_start_date"]').val();
  let work_end_date = $('input[name="work_end_date"]').val();
  let user_id = $('input[name="user_id"]').val();

  //clear inputs
  $('input[name="position_name"]').val("");
  $('input[name="company_name"]').val("");
  $('input[name="work_start_date"]').val("");
  $('input[name="work_end_date"]').val("");

  $.ajax({
    type: "GET",
    url: "utils/insertExperience.php",
    data: {
      user_id: `${user_id}`,
      position_name: `${position_name}`,
      company_name: `${company_name}`,
      work_start_date: `${work_start_date}`,
      work_end_date: `${work_end_date}`,
    },
    success: function (result) {
      document.getElementById("experience-wrapper").innerHTML = result;
    },
  });
};

const handleExperienceDeleteClick = (experience_id) => {
  let user_id = $('input[name="user_id"]').val();
  $.ajax({
    type: "GET",
    url: "utils/removeExperience.php",
    data: {
      user_id: `${user_id}`,
      experience_id: `${experience_id}`,
    },
    success: function (result) {
      document.getElementById("experience-wrapper").innerHTML = result;
    },
  });
};

const handleCourseInsert = () => {
  let course_name = $('input[name="course_name"]').val();
  let course_organizer = $('input[name="course_organizer"]').val();
  let course_location = $('input[name="course_location"]').val();
  let course_start_date = $('input[name="course_start_date"]').val();
  let course_end_date = $('input[name="course_end_date"]').val();
  let user_id = $('input[name="user_id"]').val();

  //clear inputs
  $('input[name="course_name"]').val("");
  $('input[name="course_organizer"]').val("");
  $('input[name="course_location"]').val("");
  $('input[name="course_start_date"]').val("");
  $('input[name="course_end_date"]').val("");

  $.ajax({
    type: "GET",
    url: "utils/insertCourse.php",
    data: {
      user_id: `${user_id}`,
      course_name: `${course_name}`,
      course_organizer: `${course_organizer}`,
      course_location: `${course_location}`,
      course_start_date: `${course_start_date}`,
      course_end_date: `${course_end_date}`,
    },
    success: function (result) {
      document.getElementById("course-wrapper").innerHTML = result;
    },
  });
};

const handleCourseDeleteClick = (course_id) => {
  let user_id = $('input[name="user_id"]').val();
  $.ajax({
    type: "GET",
    url: "utils/removeCourse.php",
    data: {
      user_id: `${user_id}`,
      course_id: `${course_id}`,
    },
    success: function (result) {
      document.getElementById("course-wrapper").innerHTML = result;
    },
  });
};

const handleAbilityInsert = () => {
  let user_id = $('input[name="user_id"]').val();
  let ability_content = $('input[name="ability_content"]').val();

  //clear input
  $('input[name="ability_content"]').val();
  $.ajax({
    type: "GET",
    url: "utils/insertAbility.php",
    data: {
      user_id: `${user_id}`,
      ability_content: `${ability_content}`,
    },
    success: function (result) {
      document.getElementById("ability-wrapper").innerHTML = result;
    },
  });
};

const handleAbilityDeleteClick = (ability_id) => {
  let user_id = $('input[name="user_id"]').val();
  $.ajax({
    type: "GET",
    url: "utils/removeAbility.php",
    data: {
      user_id: `${user_id}`,
      ability_id: `${ability_id}`,
    },
    success: function (result) {
      document.getElementById("ability-wrapper").innerHTML = result;
    },
  });
};

const handleLanguageInsert = () => {
  let user_id = $('input[name="user_id"]').val();
  let language_content = $('input[name="language_content"]').val();
  let language_level = $('select[name="language_level"]').val();

  //clear input
  $('input[name="language_content"]').val("");
  $('select[name="language_level"]').val("");
  $.ajax({
    type: "GET",
    url: "utils/insertLanguage.php",
    data: {
      user_id: `${user_id}`,
      language_content: `${language_content}`,
      language_level: `${language_level}`,
    },
    success: function (result) {
      document.getElementById("language-wrapper").innerHTML = result;
    },
  });
};

const handleLanguageDeleteClick = (language_id) => {
  let user_id = $('input[name="user_id"]').val();
  $.ajax({
    type: "GET",
    url: "utils/removeLanguage.php",
    data: {
      user_id: `${user_id}`,
      language_id: `${language_id}`,
    },
    success: function (result) {
      document.getElementById("language-wrapper").innerHTML = result;
    },
  });
};

const handleLinkInsert = () => {
  let user_id = $('input[name="user_id"]').val();
  let link_content = $('input[name="link_content"]').val();

  //clear inputs
  $('input[name="link_content"]').val("");
  $.ajax({
    type: "GET",
    url: "utils/insertLink.php",
    data: {
      user_id: `${user_id}`,
      link_content: `${link_content}`,
    },
    success: function (result) {
      document.getElementById("link-wrapper").innerHTML = result;
    },
  });
};

const handleLinkDeleteClick = (link_id) => {
  let user_id = $('input[name="user_id"]').val();
  $.ajax({
    type: "GET",
    url: "utils/removeLink.php",
    data: {
      user_id: `${user_id}`,
      link_id: `${link_id}`,
    },
    success: function (result) {
      document.getElementById("link-wrapper").innerHTML = result;
    },
  });
};
