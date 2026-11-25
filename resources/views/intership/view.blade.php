<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Letter pad </title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body{
    background:#f2f4f7;
    font-family: "Poppins", sans-serif;
}

/* A4 PAGE SETUP */
@page{
    size: A4;
    margin: 20mm;
}

.certificate-wrapper{
    width: 210mm;
    min-height: 297mm;
    margin: auto;
    background:#fff;
        padding: 13mm 8mm;
    box-sizing: border-box;
    box-shadow:0 10px 25px rgba(0,0,0,.15);
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.header{
    text-align:center;
}

.office-name{
    font-size:26px;
    font-weight:700;
    letter-spacing:1px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    color:#e74248;
}

.office-name img{
    height:60px;
}

.sub-office{
    font-size:25px;
    font-weight:600;
    color:#31c0c9;
}

.title{
    text-align:center;
    font-size:30px;
    font-weight:600;
    color:#ec1e25;
    letter-spacing:2px;
    margin:20px 0;
    text-transform:uppercase;
    text-decoration:underline;
}

.content{
    font-size:22px;
    text-align:justify;
}

.content p{
    text-indent:40px;
    line-height:2;
    margin-bottom:18px;
}

.signature{
    display:flex;
    justify-content:space-between;
    font-size:18px;
    margin-top:40px;
}

.footer{
    text-align:center;
    font-size:17px;
    line-height:1.6;
    margin-top:25px;
}

.print-btn{
    text-align:center;
    margin:20px;
}

button{
    padding:10px 30px;
    font-size:16px;
    cursor:pointer;
}

hr{
    border:1px solid #000;
}

@media print{
    body{background:#fff;}
    .print-btn{display:none;}
    .certificate-wrapper{box-shadow:none;}
}
@media print {

    .print-btn,
    .back-btn{
        display:none !important;
    }

    #medicineEditor{
        display:none !important;
        visibility:hidden !important;
        height:0 !important;
        overflow:hidden !important;
        margin:0 !important;
        padding:0 !important;
    }

}
    }

</style>
</head>
<body>

<div class="certificate-wrapper">

    <div class="header">
        <div class="office-name">
            <img src="{{ asset('assets/uploads/sswf/favicon-256.png') }}" alt="Logo">
            Soil Sons Welfare Foundation 
        </div>
         <div class="sub-office">
            PSYCHOLOGICAL & PSYCHIATRIC
        </div>
        <div class="sub-office">
            DE - ADDICTION AND REHABILITATION CENTRE
        </div>
        <span style="color: #002b7c">No. 68/0, Ahimsapuram, Mela Street, Puthiyavisalam (Sivagami Street), Sellur, Madurai, Tamil Nadu 625002<br>
            Ph : +91 74181 44991, 74181 44992, 0452 400 2111 || Email: {{ config('site.email') }}</span>
    </div>
<hr>

<div id="medicineEditor" style="margin-top:30px;">

    <div style="
        border:1px solid #dcdcdc;
        border-radius:10px;
        padding:20px;
        background:#fafafa;
        display:flex;
        align-items:flex-start;
        gap:20px;">

        <!-- Left -->
        <div style="width:180px;">
            <h4 style="
                margin:0 0 8px;
                color:#6b50a1;
                font-weight:700;">
                
            </h4>

            <label style="
                font-weight:600;
                color:#333;">
                Enter 
            </label>
        </div>

        <!-- Right -->
        <div style="flex:1;">
            <textarea
                id="medicine_list"
                class="form-control"
                rows="10"
                placeholder="Example:

1. T. RISPERIDONE 2MG        1-0-1
2. T. TRIDYL 2MG             1-0-0
3. T. THYROX 100MG           1-0-0

One medicine per line..."
                style="
                    width:100%;
                    resize:vertical;
                    font-size:16px;
                    line-height:1.8;
                    font-family:Consolas, monospace;
                    border:1px solid #ccc;
                    border-radius:8px;
                    padding:12px;
                    box-sizing:border-box;"></textarea>
        </div>

    </div>

</div>
  <br>
<!--    <p style="margin-top:25px;">-->
<!--    <strong>-->
<!--        Patient is advised to continue prescribed medications and review at outpatient department after 15 days.-->
<!--    </strong>-->
<!--</p>-->
<div id="medicinePreview"
     style="
        margin-top:15px;
        border:1px solid #ddd;
        border-radius:10px;
        padding:18px;
        background:#fff;
        min-height:180px;">

    <table style="width:100%;border-collapse:collapse;" id="medicineTable">
        <tbody></tbody>
    </table>

</div>
  <br><br><br>

    <!--<div style="text-align:right; margin-top:60px;">-->
    <!--    <strong style="font-size:18px;">DR. SANJAY BOSE MBBS., MD., (PSY)</strong><br>-->
    <!--    <span style="font-size:17px;">Consultant Psychiatrist</span>-->
    <!--</div>-->

    <br><br>

    <!--<div style="font-size:13px; text-align:justify; color:#555;">-->
    <!--    <strong>(This is not a legal document.</strong>-->
    <!--    This report is given to enable the patient to understand the patient's-->
    <!--    disease nature, treatment and follow up. Any clarification, if necessary,-->
    <!--    should be discussed with the consultant.)-->
    <!--</div>-->

</div>
    </div>
    
  </div>
<!--    <div class="title">Internship Certificate</div>-->

<!--    <div class="content">-->

<!--        <p>-->
<!--        This is to certify that -->
<!--        <span class="highlight">{{ $internship->student_details }}</span> -->
<!--        has successfully completed her field work training from -->
<!--        <span class="highlight">{{ $internship->training_period }}</span> -->
<!--        at Soil Sons Welfare Foundation, Madurai.-->
<!--        </p>-->

<!--        <p>-->
<!--        {{ $internship->pronoun }} is sincere and participated in <b>-->
<!--            COUNSELLING, ASSESSMENT, GROUP THERAPY,CLINICAL ACTIVITES-->
<!--        </b>   -->
<!--        , I wish her all success @if($internship->pronoun = 'she') her @else him @endif future.	-->
<!--        </p>-->

<!--        <p>-->
<!--        We wish {{ $internship->pronoun }} all success in the future.-->
<!--        </p>-->

<!--    </div>-->

<!--    <div class="signature">-->
<!--        <div>-->
<!--           <b> PLACE : Madurai <br>-->
<!--            DATE :              </b>-->
<!--        </div>-->

<!--        <div style="text-align:right;">-->
<!--            <b> K. RATHINAM <br>-->
<!--            Director of ICDS </b>-->
<!--        </div>-->
<!--    </div>-->

<!--    <div class="footer">-->
<!--        <strong>Contact :</strong><br>-->
<!--        No. 68/0, Ahimsapuram, Mela Street, Puthiyavisalam (Sivagami Street), Sellur, Madurai, Tamil Nadu 625002<br>-->
<!--        Mobile : 74181 44991-->
<!--    </div>-->

<!--</div>-->
<script>
const medicineInput = document.getElementById('medicine_list');
const medicineBody = document.querySelector('#medicineTable tbody');

medicineInput.addEventListener('input', function () {

    medicineBody.innerHTML = '';

    const lines = this.value.split('\n');

    lines.forEach(function(line){

        line = line.trim();

        if(line === '') return;

        // Last value = Dosage (1-0-1)
        const match = line.match(/^(.*)\s+([0-9]+-[0-9]+-[0-9]+)$/);

        let medicine = line;
        let dosage = '';

        if(match){
            medicine = match[1];
            dosage = match[2];
        }

        medicineBody.innerHTML += `
            <tr style="border-bottom:1px solid #e6e6e6;">
                <td style="padding:8px 10px;">
                    ${medicine}
                </td>

                <td style="
                    padding:8px 10px;
                    width:90px;
                    text-align:right;
                    font-weight:bold;">
                    ${dosage}
                </td>
            </tr>
        `;
    });

});
</script>

<div class="print-btn">
    <button onclick="window.print()">Print Certificate</button>
</div>

</body>
</html>
