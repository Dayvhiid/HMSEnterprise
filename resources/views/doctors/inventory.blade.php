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
.statusbar{
    width: 20%;
    margin-left: 2%;
}
.statusbar div{
    margin-bottom: 10%;
}
.home{
    display: flex;
    justify-content: space-around;
    height: 5%px;
    width: 5%px;
}
.home p{
    font-weight: 400;
}
.homepng{
    margin-top: 6%;
}
.patients{
    display: flex;
    justify-content: space-around;
    height: 5%px;
    width: 5%px;
}
.patients p{
    font-weight: 400;
}
.patientpng{
    margin-top: 6%;
}

.app{
    display: flex;
    justify-content: space-around;
    height: 5%px;
    width: 5%px;
}
.app p{
    font-weight: 400;
}
.apppng{
    margin-top: 6%;
}
.billing{
    display: flex;
    justify-content: space-around;
    height: 5%px;
    width: 5%px;
}
.billing p{
    font-weight: 400;
}
.billingpng{
    margin-top: 6%;
}
.records{
    display: flex;
    justify-content: space-around;
    height: 5%px;
    width: 5%px;
}
.records p{
    font-weight: 400;
}
.recordspng{
    margin-top: 6%;
}
.patientBtn{
  padding: 15px 55px;
  background-color: green;
  border-radius: 10px;
  border: 1px solid green;
  position: absolute;
  bottom: 15%;
  color: #ccc;
  margin-left: 1%;
}
.main{
    display: flex;
    width: 100%;
}
.content{
    margin-left: auto;
    margin-right: auto;
    width: 80%;
}
.search{
    width: 130%;
    display: flex;
    margin-left: 20%;
}
.form1{
    margin-top: 3%;
    display: flex;
    width: 45%;
}
.search_input{
    border: 1px solid grey;
    border-radius: 5px;
    padding: 10px 10px;
    width: 110%;
}
.searchBtn{
    background-color: green;
    border-radius: 5px;
    border: 1px solid green;
    width: 40%;
    color: white;
}
table{
  border-collapse: collapse;
  margin-left: auto;
  margin-right: auto;
}
.buttons{
    margin-left: 70%;
}
.saveBtn{
    background-color: green;
    padding: 5px 15px;
    border: 1px solid green;
    border-radius: 5px;
    color: white;
}
.printBtn{
    background-color: orange;
    padding: 5px 15px;
    border: 1px solid orange;
    border-radius: 5px;
    color: white;
}
@media print {
  #entire-page {
    display: none;  /* Hide everything except the printable content */
  }
  #printableContent {
    display: block;  /* Ensure the printable content is displayed */
  }
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
@include('partials.session-bar')
    <div class="navbar">
        <h2>Inventory</h2>
        <div class="links">
            <ul>
                <li>New Patients</li>
                <li>Invoice</li>
                <li><a href="{{route('doctors.reciept')}}">Reciept</a></li>
            {{-- <button class="doc" onclick="window.location.href='/HMS/hospital/doc.html'">
              <img src="/HMS/hospital/images/doctor.png" height="35px" width="35px">
            </button> --}}
            </ul>
        </div>
    </div>
    <div class="main">
        <div class="statusbar">
            <div class="home">
              <img height="35px" width="35px" class="homepng" src="/hospital/images/house.png">
              <p>Home</p>
            </div>
            <!-- Patients -->
            <div class="patients">
              <img height="35px" width="35px" class="patientpng" src="/hospital/icons/patient(1).png">
              <p>Drug</p>
            </div>
            <!-- Appointment -->
            <div class="app">
              <img height="35px" width="35px" class="apppng" src="/hospital/icons/appointment.png">
              <p>Lens</p>
            </div>
            <!-- Billing -->
            <div class="billing">
              <img height="35px" width="35px" class="billingpng" src="/hospital/icons/bill.png">
              <p>Frames</p>
            </div>
            <!-- Records -->
            <div class="button">
              <input type="submit" class="patientBtn" value="New Patient" onclick="window.location.href='/HMS/hospital/newPatient.php';">
            </div>
         </div>
         <div class="content">
            <div class="search">
                {{-- <form action="{{route('inventory.store')}}" method="post" class="form1">
                    <input type="text" placeholder="Enter Drug Name" class="search_input">
                    <input type="submit" value="Search" class="searchBtn"> 
                </form> --}}
          </div>
          <div class="table">
            <form action="{{route('inventory.store')}}" method="POST">
              @csrf
              @method('POST')
            <table border="1">
                <tr>
                  <td>S/N</td>
                  <td>DATE</td>
                  <td>NEW STOCK</td>
                  <td colspan="3">PARTICULARS</td>
                  <td>QTY IN</td>
                  <td>QTY OUT</td>
                  <td>BALANCE</td>
                  {{-- <td></td>
                  <td></td>
                  <td></td> --}}
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>NAME</td>
                  <td>PATIENT CODE</td>
                  <td>BOOKLET RECIEPT NO.</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td><input type="text" name="sn[]"></td>
                  <td><input type="date" name="date[]"></td>
                  <td><input type="text" name="new_stock[]"></td>
                  <td><input type="text" name="name[]"></td>
                  <td><input type="text" name="patient_code[]"></td>
                  <td><input type="text" name="booklet_no[]"></td>
                  <td><input type="text" name="qty_in[]"></td>
                  <td><input type="text" name="qty_out[]"></td>
                  <td><input type="text" name="balance[]"></td>
                </tr>
                <tr>
                  <td><input type="text" name="sn[]"></td>
                  <td><input type="date" name="date[]" ></td>
                  <td><input type="text" name="new_stock[]"></td>
                  <td><input type="text" name="name[]"></td>
                  <td><input type="text" name="patient_code[]"></td>
                  <td><input type="text" name="booklet_no[]"></td>
                  <td><input type="text" name="qty_in[]"></td>
                  <td><input type="text" name="qty_out[]"></td>
                  <td><input type="text" name="balance[]"></td>
                </tr>
                {{-- <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr> --}}
              </table>
                  {{-- controls --}}
                <div class="buttons">
                    <input type="submit" value="SAVE" class="saveBtn">
                    <input type="button" value="PRINT" class="printBtn" id="printBtn">
                </div>  
            </form>  
          </div>
         </div>
         <script>
            const printBtn = document.getElementById('printBtn');
            printBtn.addEventListener('click', function (){
                print();
            })
         </script>
</body>
</html>