<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h4>Courses</h4>
                            </div>
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                    Add Course
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <div id="alert"></div>
                        <div id="courses-section">
                            <!-- <table class="table table-bordered m-0" id="table">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Name</th>
                                        <th>Duration</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody">
                                    <tr>
                                        <td>1</td>
                                        <td>Programming</td>
                                        <td>4 Months</td>
                                        <td>Date</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> -->

                            <!-- <div class="alert alert-info m-0" id="alert-msg">
                                no record found
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once './partials/modals.php'; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script>
        showCourses();

        const addFormElement = document.querySelector("#add-form");
        const alertAddElement = document.querySelector("#alert-add");

        addFormElement.addEventListener("submit", function(e) {
            e.preventDefault();

            const nameAddElement = document.querySelector("#name-add");
            const durationAddElement = document.querySelector("#duration-add");

            let nameAddValue = nameAddElement.value;
            let durationAddValue = durationAddElement.value;

            nameAddElement.classList.remove("is-invalid");
            durationAddElement.classList.remove("is-invalid");

            if (nameAddValue == "") {
                alertAddElement.innerHTML = alert("danger", "Enter course name");
                nameAddElement.classList.add("is-invalid");
            } else if (durationAddValue == "") {
                alertAddElement.innerHTML = alert("danger", "Enter course duration");
                durationAddElement.classList.add("is-invalid");
            } else {
                const data = {
                    name: nameAddValue,
                    duration: durationAddValue,
                    submit: 1,
                };


                fetch("./add-course.php", {
                        method: "POST",
                        body: JSON.stringify(data),
                        headers: {
                            'Content-Type': 'application.json'
                        }
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(result) {
                        if (result.nameError) {
                            alertAddElement.innerHTML = alert("danger", result.nameError);
                            nameAddElement.classList.add("is-invalid");
                        } else if (result.durationError) {
                            alertAddElement.innerHTML = alert("danger", result.durationError);
                            durationAddElement.classList.add("is-invalid");
                        } else if (result.failure) {
                            alertAddElement.innerHTML = alert("danger", result.failure);
                        } else if (result.success) {
                            alertAddElement.innerHTML = alert("success", result.success);
                            nameAddElement.value = "";
                            durationAddElement.value = "";
                            showCourses();
                        } else {
                            alertAddElement.innerHTML = alert("danger", "Something went wrong");
                        }
                    })
            }
        });

        function showCourses() {
            const coursesSectionElement = document.querySelector("#courses-section");

            fetch("./show-courses.php")
                .then(function(response) {
                    return response.json();
                })
                .then(function(result) {
                    if (result.length !== 0) {
                        let rows = "";
                        let sr = 1;
                        result.forEach(function (value) {
                            rows += `<tr>
                                        <td>${sr++}</td>
                                        <td>${value.name}</td>
                                        <td>${value.duration}</td>
                                        <td>${value.created_at}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>`
                        });

                        coursesSectionElement.innerHTML = `<table class="table table-bordered m-0" id="table">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Name</th>
                                        <th>Duration</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody">
                                    ${rows}
                                </tbody>
                            </table>`;
                    } else {
                        coursesSectionElement.innerHTML = `<div class="alert alert-info m-0" id="alert-msg">
                                No record found
                            </div>`;
                    }
                    // console.log(result);
                });
        }

        function alert(cls = "danger", msg) {
            return `<div class="alert alert-${cls} alert-dismissible fade show" role="alert">
            ${msg}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
        }
    </script>

</body>

</html>