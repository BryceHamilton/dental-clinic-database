<html>

<head>
    <title>New Appointment</title>
    <link rel='stylesheet' type='text/css' href='dentists.css' />
    <style>
      form.add {
          display: block;
      }
  
      .flex-wrap {
        display: flex;
        justify-content: center;
        height: 100vh;
        align-items: center;
        flex-direction: column;
      }

      h2 {
          font-style: italic;
      }

      .span-2 {
          grid-column-start: span 2;
      }

      .note {
          width: 100%;
          margin-top: 10px;
      }
    </style>
</head>

<body>
    <div class='flex-wrap'>
    <h2>New Appointment</h2>
        <form action='addAppointment.php' method='POST' class='add'>
        <input type="hidden" name='healthCardID' value='<?echo $_GET['Patient'] ?>'>
        <input type="hidden" name='clinicID' value='<?echo $_GET['clinic'] ?>'>
        <? echo isset($_GET['dentist']) ? "<input type='hidden' name='dentistID' value='" . $_GET['dentist'] . "'>" : ""; ?>
            <div class='add-form'>
                <span class='close' onClick='window.location = "Home.php"'>&times;</span>
                <div class='grid-cell'>
                    <label>Clinic ID:</label>
                    <label><? echo $_GET['clinic'] ?></label>
                </div>
                <div class='grid-cell'>
                    <label>Health Card ID:</label>
                    <label><? echo $_GET['Patient'] ?></label>
                </div>
                <div class='grid-cell span-2'>
                    <label>Dentist ID:</label>
                    <label><? echo isset($_GET['dentist']) ? $_GET['dentist'] : "None" ?></label>
                </div>
                <div class='grid-cell span-2'>
                    <label>Schedule Time</label>
                    <input style='margin-left: 5px;' type='datetime-local' id='scheduledTime' name='scheduledTime' required>
                </div>
                <div class='grid-cell span-2'>
                    <label>Note</label>
                    <div>
                    <textarea class='note' rows='3' columns='15' id='note' name='note'></textarea>
                    </div>
                </div>


                <input id="submit" type="submit" value="ADD">
            </div>
        </form>
    </div>
</body>

</html>