<?php


/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */
?>

<form id="eventForm">
    <label for="eventTitle">Názov udalosti:</label>
    <input type="text" id="eventTitle" name="eventTitle" required placeholder="Zadajte názov udalosti">

    <label for="eventDate">Dátum udalosti:</label>
    <input type="text" id="eventDate" name="eventDate" required placeholder="Vyberte dátum udalosti">

    <label for="eventDescription">Popis udalosti:</label>
    <textarea id="eventDescription" name="eventDescription" placeholder="Napíšte popis udalosti"></textarea>

    <button type="submit">Pridať udalosť</button>
</form>

<script>
    $(document).ready(function() {
        $('#eventDate').datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0,
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true
        });
    });
</script>
