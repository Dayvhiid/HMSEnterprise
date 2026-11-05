<style>
    body{
      overflow-x: hidden;
    }
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
/* .main{
    display: flex;
    width: 100%;
}
.content{
    margin-left: auto;
    margin-right: auto;
    width: 80%;
} */
.search{
    width: 130%;
    display: flex;
    margin-left: 20%;
}
.form1{
  
    width: 60%;
    margin-left: auto;
    margin-right: auto; 
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
.textarea{
     display: grid;
     align-items: center;
}
.textarea label{
    padding-top: 2%;
  margin-left: 20%;
}
.dosage{
    width: 60%;
    margin-left: auto;
    margin-right: auto;
    border: 1px solid grey;
    border-radius: 5px;
    padding: 10px 10px;
    background-color: #dddddd;
  color: #666666;
  padding: 1em;
  border-radius: 10px;
  border: 2px solid transparent;
  outline: none;
  font-family: "Heebo", sans-serif;
  font-weight: 500;
  font-size: 16px;
  line-height: 1.4;
  height: 100px;
  transition: all 0.2s;
}
.remark{
    width: 60%;
    margin-left: auto;
    margin-right: auto; 
}
.duration{
    display: grid;
     align-items: center;  
}
.durationMenu{
    width: 60%;
    margin-left: auto;
    margin-right: auto;
}
.duration label{
    padding-top: 1%;
  margin-left: 20%;
}
.saveBtn{
    background-color: green;
    border-radius: 5px;
    border: 1px solid green;
    width: 20%;
    color: white;
}
.save{
    margin-left: 20%;
}
/* generated code */
body {
    font-family: sans-serif;
}

/* .container {
    width: 800px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
} */

h1 {
    text-align: center;
}

.table-container {
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    padding: 8px;
    border: 1px solid #ddd;
}

th {
    text-align: left;
}

.blank {
    width: 20px;
}

.fas {
    font-size: 16px;
}

.comments,
.final-diagnosis {
    margin-bottom: 20px;
}

h2 {
    margin-top: 0;
}
.single_vision{
   margin-left: 20%;
}
.Bifocal_tintable{
    margin-left: 20%; 
}
.specialOrder{
    margin-left: 20%;  
}
.progressive{
    margin-left: 20%;  
    margin-top: -10%; 
}
.alert{
   display: flex;
   justify-content: center;
   font-size: 2rem;
   margin-top: 10%;
}
.lenses{
    display: grid;
     align-items: center;
     margin-left: 15%;
}

.main {
        display: flex; 
        flex-wrap: wrap;
        width: 100%;
        
    }

    .user-container {
        flex: 0 0 calc(80.33% - 20px); /* Adjust width as needed */
        margin: 10px;
        border: 1px solid #ccc;
        padding: 10px;
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
    }

    .content {
        display: flex;
        flex-direction: column;
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
    <div class="main">
        @if($users->isEmpty())
            <div class="error-message">
                <p>No users found.</p>
            </div>
        @else
            @foreach ($users as $user)
                <div class="user-container">
                    <div class="content">
                        <div class="form1">
                            <p>{{$user->created_at}}</p>
                            <label for="TextArea">Patient ID:</label>
                            <input type="text" value="{{ $user->patient_id }}" placeholder="Enter Patient Id" name="patient_id" class="search_input" readonly>
                        </div>
                        <!-- Render other fields -->
                        <div class="textarea">
                            <label for="TextArea">Dosage:</label>
                            <input class="dosage" type="text" value="{{ $user->dosage }}" readonly>
                        </div>
                        <div class="duration">
                            <label for="">DURATION:</label>
                            <input class="dosage" type="text" value="{{ $user->duration }}" readonly>
                        </div>
                        <div class="textarea">
                            <label for="TextArea">TAB:</label>
                            <input class="dosage" type="text" value="{{ $user->tab }}" readonly>
                        </div>
                        <div class="textarea">
                            <label for="TextArea">GUTT:</label>
                            <input class="dosage" type="text" value="{{ $user->gutt }}" readonly>
                        </div>
                        <div class="textarea">
                            <label for="TextArea">OC:</label>
                            <input class="dosage" type="text" value="{{ $user->oc }}" readonly>
                        </div>
                        <div class="textarea">
                            <label for="TextArea">SUR:</label>
                            <input class="dosage" type="text" value="{{ $user->sur }}" readonly>
                        </div>
                        <div class="textarea">
                            <label for="TextArea">RTC:</label>
                            <input class="dosage" type="text" value="{{ $user->rtc }}" readonly>
                        </div>
                        <div class="textarea">
                            <label for="TextArea">Prescription:</label>
                            <input class="dosage" type="text" value="{{ $user->prescription }}" readonly>
                        </div>
                        <div class="textarea">
                            <label for="TextArea">Remark:</label>
                            <input class="dosage" type="text" value="{{ $user->remark }}" readonly>
                        </div>
                        <!-- Render lens information -->
                        <div class="lenses">
                            <h1>Lens</h1>
                            @php
                                $lensTypes = ['single_vision', 'bifocal', 'special_order', 'progressive'];
                            @endphp
                            @foreach ($lensTypes as $lensType)
                                @if ($user->$lensType)
                                    <h3>{{ ucfirst(str_replace('_', ' ', $lensType)) }}</h3>
                                    @foreach (json_decode($user->$lensType, true) ?? [] as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div><br>
            @endforeach
        @endif
    </div>
</body>
