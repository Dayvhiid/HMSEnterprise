<style>
    *,
*::after,
*::before{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

:root{
    --blue-color: #0c2f54;
    --dark-color: #535b61;
    --white-color: #fff;
}

ul{
    list-style-type: none;
}
ul li{
    margin: 2px 0;
}

/* text colors */
.text-dark{
    color: var(--dark-color);
}
.text-blue{
    color: var(--blue-color);
}
.text-end{
    text-align: right;
}
.text-center{
    text-align: center;
}
.text-start{
    text-align: left;
}
.text-bold{
    font-weight: 700;
}
/* hr line */
.hr{
    height: 1px;
    background-color: rgba(0, 0, 0, 0.1);
}
/* border-bottom */
.border-bottom{
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

body{
    font-family: 'Poppins', sans-serif;
    color: var(--dark-color);
    font-size: 14px;
}
.invoice-wrapper{
    min-height: 100vh;
    background-color: rgba(0, 0, 0, 0.1);
    padding-top: 20px;
    padding-bottom: 20px;
}
.invoice{
    max-width: 850px;
    margin-right: auto;
    margin-left: auto;
    background-color: var(--white-color);
    padding: 70px;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 5px;
    min-height: 920px;
}
.invoice-head-top-left img{
    width: 130px;
}
.invoice-head-top-right h3{
    font-weight: 500;
    font-size: 27px;
    color: var(--blue-color);
}
.invoice-head-middle, .invoice-head-bottom{
    padding: 16px 0;
}
.invoice-body{
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    overflow: hidden;
}
.invoice-body table{
    border-collapse: collapse;
    border-radius: 4px;
    width: 100%;
}
.invoice-body table td, .invoice-body table th{
    padding: 12px;
}
.invoice-body table tr{
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.invoice-body table thead{
    background-color: rgba(0, 0, 0, 0.02);
}
.invoice-body-info-item{
    display: grid;
    grid-template-columns: 80% 20%;
}
.invoice-body-info-item .info-item-td{
    padding: 12px;
    background-color: rgba(0, 0, 0, 0.02);
}
.invoice-foot{
    padding: 30px 0;
}
.invoice-foot p{
    font-size: 12px;
}
.invoice-btns{
    margin-top: 20px;
    display: flex;
    justify-content: center;
}
.invoice-btn{
    padding: 3px 9px;
    color: var(--dark-color);
    font-family: inherit;
    border: 1px solid rgba(0, 0, 0, 0.1);
    cursor: pointer;
}

.invoice-head-top, .invoice-head-middle, .invoice-head-bottom{
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    padding-bottom: 10px;
}

@media screen and (max-width: 992px){
    .invoice{
        padding: 40px;
    }
}

@media screen and (max-width: 576px){
    .invoice-head-top, .invoice-head-middle, .invoice-head-bottom{
        grid-template-columns: repeat(1, 1fr);
    }
    .invoice-head-bottom-right{
        margin-top: 12px;
        margin-bottom: 12px;
    }
    .invoice *{
        text-align: left;
    }
    .invoice{
        padding: 28px;
    }
}

.overflow-view{
    overflow-x: scroll;
}
.invoice-body{
    min-width: 600px;
}

@media print{
    .print-area{
        visibility: visible;
        width: 100%;
        position: absolute;
        left: 0;
        top: 0;
        overflow: hidden;
    }

    .overflow-view{
        overflow-x: hidden;
    }

    .invoice-btns{
        display: none;
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
    <form action="{{route('invoice.search', ['users' => $users])}}" type="get">
        
          @foreach($users as $user) 
           {{-- The main code runs here --}}
           <div class = "invoice-wrapper" id = "print-area">
            <div class = "invoice">
                <div class = "invoice-container">
                    <div class = "invoice-head">
                        <div class = "invoice-head-top">
                            <div class = "invoice-head-top-left text-start">
                                <img src="/icons/logo.png">
                            </div>
                            <div class = "invoice-head-top-right text-end">
                                <h3>Invoice</h3>
                            </div>
                        </div>
                        <div class = "hr"></div>
                        <div class = "invoice-head-middle">
                            <div class = "invoice-head-middle-left text-start">
                                <p><span class = "text-bold">Date</span>@php echo date('Y-m-d H:i:s') @endphp</p>
                            </div>
                            <div class = "invoice-head-middle-right text-end">
                                <p><spanf class = "text-bold">Patient Name:</span>{{ $user->pid}}</p>
                            </div>
                        </div>
                        <div class = "hr"></div>
                        <div class = "invoice-head-bottom">
                            <div class = "invoice-head-bottom-left">
                                <ul>
                                    <li class = 'text-bold'>Invoiced To:</li>
                                    <li>{{ $user->pid}}</li>
                                  
                                </ul>
                            </div>
                            <div class = "invoice-head-bottom-right">
                                <ul class = "text-end">
                                    <li class = 'text-bold'>Pay To:</li>
                                    <li>{{ config('clinic.name') }}</li>
                                <li>{{ config('clinic.address') }}</li>
                                <li>{{ config('clinic.phone') }}</li>
                                    {{-- <li>2705 N. Enterprise</li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class = "overflow-view">
                        <div class = "invoice-body">
                            <table>
                                <thead>
                                    <tr>
                                        {{-- <td class = "text-bold">Service</td> --}}
                                        <td class = "text-bold">Description</td>
                                        <td class = "text-bold">Rate</td>
                                        <td class = "text-bold">QTY</td>
                                        <td class = "text-bold">Amount</td>
                                    </tr>
                                </thead>
                                <tbody>
                                     {{-- <tr>
                                         <td>Design</td> 
                                        <td>Creating a website design</td>
                                        <td>$50.00</td>
                                        <td>10</td>
                                        <td class = "text-end">$500.00</td>
                                    </tr>  --}}
                                    <?php  $subtotal=0 ?>
                                    @foreach($user->name as $index => $item)
                                    <tr>
                                        <td>{{$item}}</td>  
                                        <td><span>&#8358</span>{{$user->price[$index]}}</td>  
                                        <td>{{$user->qty[$index]}}</td>   
                                        <td> <span>&#8358</span>{{ ($user->price[$index]) * ($user->qty[$index]) }}</td>  
                                        <?php  $subtotal += ($user->price[$index]) * ($user->qty[$index]); ?> 
                                        <?php $discount_amount = $subtotal * ($user->discount / 100);?>   
                                        <?php $discounted_subtotal = $subtotal - $discount_amount;?>
                                    </tr>
                                @endforeach
                                
                                    {{-- <tr>
                                        <td>Development</td>
                                        <td>Website Development</td>
                                        <td>$50.00</td>
                                        <td>10</td>
                                        <td class = "text-end">$500.00</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>SEO</td>
                                        <td>Optimize the site for search engines (SEO)</td>
                                        <td>$50.00</td>
                                        <td>10</td>
                                        <td class = "text-end">$500.00</td>
                                    </tr> --}}
                                    <!-- <tr>
                                        <td colspan="4">10</td>
                                        <td>$500.00</td>
                                    </tr> -->
                                </tbody>
                            </table>
                            <div class = "invoice-body-bottom">
                                <div class = "invoice-body-info-item border-bottom">
                                    <div class = "info-item-td text-end text-bold">Sub Total:</div>
                                    <div class = "info-item-td text-end"><span>&#8358</span>@php echo $discounted_subtotal @endphp</div>
                                </div>
                                {{-- <div class = "invoice-body-info-item border-bottom">
                                    <div class = "info-item-td text-end text-bold">Tax:</div>
                                    <div class = "info-item-td text-end">$215.00</div>
                                </div>
                                <div class = "invoice-body-info-item">
                                    <div class = "info-item-td text-end text-bold">Total:</div>
                                    <div class = "info-item-td text-end">$21365.00</div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class = "invoice-foot text-center">
                        <p><span class = "text-bold text-center">NOTE:&nbsp;</span>The price is generated at {{$user->discount}}% discount.</p>

                        <div class = "invoice-btns">
                            <button type = "button" class = "invoice-btn" onclick="printInvoice()">
                                <span>
                                    <i class="fa-solid fa-print"></i>
                                </span>
                                <span>Print</span>
                            </button>
                            <button type = "button" class = "invoice-btn">
                                <span>
                                    <i class="fa-solid fa-download"></i>
                                </span>
                                <span>Download</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function printInvoice(){
           window.print();
          }
        </script>
    </body>
          
          @endforeach
    </form>
</body>
</html>