const company_input_wrapper = document.querySelector("#company-input-wrapper");
const company_select = document.querySelector("#company-select");
const company_add = document.querySelector("[name=company_add]");

const requirement_input = document.querySelector("#requirement-input");
const requirement_button = document.querySelector("#requirement-button");
const requirement_list = document.querySelector("#requirement-list");

const benefit_input = document.querySelector("#benefit-input");
const benefit_button = document.querySelector("#benefit-button");
const benefit_list = document.querySelector("#benefit-list");

const duty_input = document.querySelector("#duty-input");
const duty_button = document.querySelector("#duty-button");
const duty_list = document.querySelector("#duty-list");

company_select.addEventListener("change", (e) => {
  if (e.currentTarget.value === "Dodaj nową") {
    company_input_wrapper.classList.add("grid");
    company_input_wrapper.classList.remove("hidden");
    company_add.value = "true";
  } else {
    company_input_wrapper.classList.remove("grid");
    company_input_wrapper.classList.add("hidden");
    company_add.value = "false";
  }
});

requirement_button.addEventListener("click", (e) => {
  let requirement = requirement_input.value;
  const input = document.createElement("input");
  const li = document.createElement("li");
  input.setAttribute("name", "requirements[]");
  input.setAttribute("value", requirement);
  li.append(input);
  requirement_list.append(li);
});

benefit_button.addEventListener("click", (e) => {
  console.log("click");
  let benefit = benefit_input.value;
  const input = document.createElement("input");
  const li = document.createElement("li");
  input.setAttribute("name", "benefits[]");
  input.setAttribute("value", benefit);
  li.append(input);
  benefit_list.append(li);
});

duty_button.addEventListener("click", (e) => {
  let duty = duty_input.value;
  const input = document.createElement("input");
  const li = document.createElement("li");
  input.setAttribute("name", "duties[]");
  input.setAttribute("value", duty);
  li.append(input);
  duty_list.append(li);
});

document.getElementById("category-select").addEventListener("change", (e) => {
  console.log(e.target.value);
  if (e.target.value == "Inna") {
    document.getElementById("cateogry-input").classList.add("flex");
    document.getElementById("cateogry-input").classList.remove("hidden");
  } else {
    document.getElementById("cateogry-input").classList.remove("flex");
    document.getElementById("cateogry-input").classList.add("hidden");
  }
});

document.getElementById("category-button").addEventListener("click", (e) => {
  console.log();
  if (document.getElementById("category-select").value == "Inna") {
    let category = document.getElementById("cateogry-input").value;
    const input = document.createElement("input");
    const li = document.createElement("li");
    input.setAttribute("name", "categories[]");
    input.setAttribute("value", category);
    li.append(input);
    document.getElementById("category-list").append(li);
  } else {
    let category = document.getElementById("category-select").value;
    const input = document.createElement("input");
    const li = document.createElement("li");
    input.setAttribute("name", "categories[]");
    input.setAttribute("value", category);
    li.append(input);
    document.getElementById("category-list").append(li);
  }
});

const deleteCategoryLiClick = (li_num) => {
  const category = document.querySelector(`li[group="category-li-${li_num}"]`);
  category.remove();
};

const deleteRequirementClick = (li_num) => {
  const requirement = document.querySelector(
    `li[group="requirement-li-${li_num}"]`
  );
  requirement.remove();
};

const deleteBenefitClick = (li_num) => {
  const benefit = document.querySelector(`li[group="benefit-li-${li_num}"]`);
  benefit.remove();
};

const deleteDutyClick = (li_num) => {
  const duty = document.querySelector(`li[group="duty-li-${li_num}"]`);
  duty.remove();
};
