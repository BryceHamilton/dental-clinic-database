<HTML>

<HEAD>
    <TITLE>DB Kings</TITLE>
    <link rel='stylesheet' href='styles.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
    .new-dentist-btn:hover {
        background-color: #45a049;
    }

    .new-dentist-btn {
        background-color: #4caf50;
        color: white;
        padding: 14px 20px;
        margin: 20px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .new-dentist-btn:focus {
        outline: none;
    }
    .grid {
    display: grid;
}

.center {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.wrapper {
    display: flex;
    justify-content: center;
}

h3 {
    font-style: italic;
}
       
.row {
    display: flex;
}



.back {
    padding: 10px;
}

.middle {
    height: 100vh;
    align-items: center;
}

.cell {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
  }
  
  .cell {
    border: 1px solid #ddd;
    padding: 8px;
  }
  
  .cell div:nth-child(even){background-color: #f2f2f2;}
  
  .row div:hover {background-color: #ddd;}
  
  .head {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    background-color: red;
    color: white;
  }

  .no-hov:hover {
      cursor: auto;
  }
    </style>


</HEAD>

<BODY>
    <div class="center middle">
        <div>
            <div class='center no-hov' style='margin: 10px; font-size: 32px; color: #4caf50 !important;'><i
                    class='fa fa-home no-hov' onclick="redirect('Home.php')"></i>
            </div>
            <a href="./Patients.php"><button class='new-dentist-btn'>Patients</button></a>
            <a href="./Employees.php"><button class='new-dentist-btn'>Employees</button></a>
            <a href="./Clinics.php"><button class='new-dentist-btn'>Clinics</button></a>
            <a href="./Bills.php"><button class='new-dentist-btn'>Bills</button></a>
            <a href="./admin.php"><button class='new-dentist-btn'>Admin</button></a>
            <div style='display: flex; justify-content: center;'>
                <a href="./Patients.php?Appt=true"><button class='new-dentist-btn'>Schedule New Appointment</button></a>
            </div>

        </div>
    </div>
</BODY>

</HTML>