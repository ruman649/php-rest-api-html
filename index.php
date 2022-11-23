<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP & Ajax CRUD</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <table id="main" border="0" cellspacing="0">
        <tr>
            <td id="header">
                <h1>PHP REST API CRUD</h1>

                <div id="search-bar">
                    <label>Search :</label>
                    <input type="text" id="search" autocomplete="off">
                </div>
            </td>
        </tr>
        <tr>
            <td id="table-form">
                <form id="addForm">
                    Name : <input type="text" name="sname" id="sname">
                    Phone : <input type="text" name="sphone" id="sphone">
                    Roll : <input type="text" name="sroll" id="sphone">
                    Regis : <input type="text" name="sregis" id="sregis">
                    <input type="submit" id="save-button" value="Save">
                </form>
            </td>
        </tr>
        <tr>
            <td id="table-data">
                <table width="100%" cellpadding="10px">
                    <tr>
                        <th width="40px">Id</th>
                        <th>Name</th>
                        <th width="50px">Phone</th>
                        <th width="150px">Roll</th>
                        <th width="60px">Regis</th>
                        <th width="70px">Group</th>
                        <th width="70px">Edit</th>
                        <th width="70px">Delete</th>
                    </tr>
                    <tbody id="load_table">
                        <!-- <tr>
              <td class="center">1</td>
              <td>Name 1</td>
              <td>25</td>
              <td>Delhi</td>
              <td class="center"><button class="edit-btn" data-eid="">Edit</button></td>
              <td class="center"><button class="delete-btn" data-id="">Delete</button></td>
            </tr> -->

                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <div id="error-message" class="messages">fadfasdfasdf</div>
    <div id="success-message" class="messages"></div>

    <!-- Popup Modal Box for Update the Records -->
    <div id="modal">
        <div id="modal-form">
            <h2>Edit Form</h2>
            <form action="" id="edit-form">
                <table cellpadding="10px" width="100%">
                    <tr>
                        <!-- <td width="90px">ID</td> -->
                        <!-- <td><input type="text" name="sname" id="edit-id"> -->
                            <input type="text" name="sid" id="edit-id" hidden="">
                        </td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td><input type="text" name="sname" id="edit-name"></td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td><input type="text" name="sphone" id="edit-phone"></td>
                    </tr>
                    <tr>
                        <td>Roll</td>
                        <td><input type="text" name="sroll" id="edit-roll"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="button" id="edit-submit" value="Update"></td>
                    </tr>
                </table>
            </form>
            <div id="close-btn">X</div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //Fetch All Records
            function loadData() {
                $.ajax({
                    url: "http://localhost:3000/all_show.php",
                    type: 'get',
                    success: function(data) {
                        // console.log(data);
                        $('#load_table').html('');
                        if (data.status == false) {
                            $('#load_table').append("<tr><h1>" + data.data + "</h1></tr>");
                        } else {
                            $.each(data, function(key, value) {
                                // console.log(data);
                                $('#load_table').append("<tr>" +
                                    "<td>" + value.id + "</td>" +
                                    "<td>" + value.name + "</td>" +
                                    "<td>" + value.phone + "</td>" +
                                    "<td>" + value.roll + "</td>" +
                                    "<td>" + value.regis + "</td>" +
                                    "<td>" + value.groups + "</td>" +
                                    "<td class='center'><button class='edit-btn' data-eid='"+value.id+"'>Edit</button></td>" +
                                    "<td class='center'><button class='delete-btn' data-id='"+value.id+"'>Delete</button></td>" +
                                    "</tr>");
                            })
                        }

                    }
                })
            }
            loadData();

            //serializeArray data
            function collectForm(data){
                let arr = $(data).serializeArray();
                let obj = {};
                for(let i =0; i<arr.length; i++){
                    obj[arr[i].name] = arr[i].value;
                }
                let jsn = JSON.stringify(obj);
                return jsn;
            }
            // show message 
            function message(data, status){
                if(status == true){
                    $('#success-message').html(data).slideDown();
                    $('#error-message').slideUp();
                    setTimeout(function(){
                        $('#success-message').slideUp();
                    }, 3000);
                }
                else if(status==false){
                    $('#error-message').html(data).slideDown();
                    $('#success-message').slideUp();
                    setTimeout(function(){
                        $('#error-message').slideUp();
                    }, 3000);
                }
            }
            // //clear data from input form
            // $('#save-button').on('click', function(){
            //     $('#addForm').trigger('reset');
            // })


            //Insert New Record
            $('#save-button').on('click', function(e){
                e.preventDefault();
                    let jsn_data = collectForm('#addForm');
                    $.ajax({
                        url: 'http://localhost:3000/api-insert.php',
                        type: 'post',
                        data: jsn_data,
                        success: function(data){
                            message(data.data, data.status);
                            if(data.status==true){
                                loadData();
                                $('#addForm').trigger('reset');
                                
                            }
                        }
                    })
            })

            //Delete Record

            //Fetch Single Record : Show in Modal Box
            $(document).on('click', '.edit-btn', function(){
                $('#modal').show();
                let id = $(this).data('eid');
                let obj = {id:id};
                let jsn = JSON.stringify(obj);
                // console.log(jsn);

                $.ajax({
                    url: "http://localhost:3000/api-fetch-single.php",
                    type: 'post',
                    data: jsn,
                    success: function(data){
                        // console.log(data);
                        if(data.status==false){
                            $('#edit-form').html("Data not found");
                        }
                        else{
                            // console.log(data);
                            // console.log(data['0'].name);
                            // $('#edit-id').val(data[0].id);
                            $('#edit-name').val(data['0'].name);
                            $('#edit-phone').val(data['0'].phone);
                            $('#edit-roll').val(data['0'].roll);   
                        }
                    }
                })
            })
            //Hide Modal Box
            $('#close-btn').on('click', function(){
                $('#modal').hide();
            })

            //Update Record

            //Live Search Record


            //   //clear data from input form
            //   $('#save-button').on('click', function(){
            //     $('#addForm').trigger('reset');
            // })
        })
    </script>
</body>

</html>