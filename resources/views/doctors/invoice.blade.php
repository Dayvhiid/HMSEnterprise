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
.main{
    display: flex;
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
.content{
   margin-left: auto;
   margin-right: auto;
   margin-top: 2%;
}
table{
    border-collapse: collapse;
    background-color: #ccc;
    border: 1px solid black;
}
input{
    outline: none;
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
        <h2>Invoice</h2>
        <div class="links">
            <ul>
                <li>New Patients</li>
                <li>Invoice</li>
                <li>Inventory</li>
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
              <p>Reciept</p>
            </div>          
            <div class="button">
              <input type="submit" class="patientBtn" value="New Patient" onclick="window.location.href='/HMS/hospital/newPatient.php';">
            </div>
         </div>
         <div class="content">
            <table border="1" style="width:70%">
                <tr>
                    <td>S/N</td>
                    <td>Description</td>
                    <td>Rate</td>
                    <td>Amount</td>
                </tr>
                <tr>
                   <td>1</td>
                   <td><input type="text" name="desc"></td>
                   <td><input type="text" name="rate"></td>
                   <td><input type="text" name="amount"></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><input type="text" name="desc"></td>
                    <td></td>
                    <td></td>
                 </tr>
                 <tr>
                    <td>3</td>
                    <td></td>
                    <td></td>
                    <td></td>
                 </tr>
                 <tr>
                    <td>4</td>
                    <td></td>
                    <td></td>
                    <td></td>
                 </tr>
                 <tr>
                    <td>4</td>
                    <td></td>
                    <td></td>
                    <td></td>
                 </tr>
                 <tr>
                    <td>5</td>
                    <td></td>
                    <td></td>
                    <td></td>
                 </tr>
                 <tr>
                    <td>6</td>
                    <td></td>
                    <td></td>
                    <td></td>
                 </tr>
                 <tr>
                    <td>7</td>
                    <td></td>
                    <td></td>
                    <td></td>
                 </tr>
                 <tr>
                    <td>8</td>
                    <td></td>
                    <td></td>
                    <td></td>
                 </tr>
            </table>
                      
         </div>
    </div>
</body>
</html>