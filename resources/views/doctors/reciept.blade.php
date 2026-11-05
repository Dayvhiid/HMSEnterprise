<style>
    .links{
    margin-right: 5%;
    font-family: "Montserrat", sans-serif;
    font-weight: 400;
    width: 45%;
}
.links ul li{
    display: inline-block;
    list-style-type: none;
    margin-right: 10%;
    padding-top: 3%;
}
.navbar{
    display: flex;
    justify-content: space-between
}
.reciept{
    background-color: #ccc;
    width: 50%;
    height: 50%;
    margin-left: auto;
    margin-right: auto;
}
.date{
    display: flex;
}
.recievedInp{
    border: 0px;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('clinic.product_name') }}</title>
</head>
<body>
    <div class="navbar">
        <h2>Reciepts</h2>
        <div class="links">
            <ul>
                <li> New Patients</li>
                <li>Records</li>
                <li>Invoice</li>
                <li>Inventory</li>
            {{-- <button class="doc" onclick="window.location.href='/HMS/hospital/doc.html'">
              <img src="/HMS/hospital/images/doctor.png" height="35px" width="35px">
            </button> --}}
            </ul>
        </div>
    </div>
    <div class="reciept">
          <form action="">
             <div class="date">
                <h3>Date: </h3><h3><?php echo " ".date(' d/m/y') ?></h3>
             </div>
             <div class="recieved">
                <h3>Recived</h3><input type="text" class="recievedInp">
             </div>
          </form>
    </div>
</body>
</html>

{{-- <script>
        var $i = 0;
        $('#add').click(function(){
            console.log('welldon')
            ++i;
            $('#table').append(
                <tr>
                    <td>
                        "<input type="text" name="inputs['+i+'][name]" placeholder="Enter you name" class="form-control"/>"
                    <td>
                    <td>
                        <button type="button" class="btn btn-danger remove-table-row">Remove<button>
                    </td>
               </tr>');
        })
    </script> --}}