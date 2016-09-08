<html>
    <form method="post">
        <label for="name">Your name</label><br/>
        <input type="text" name="name"/><br/>

        <label for="month">Month to generate the report for</label><br/>
        <input type="text" name="month" value="<?=date('m')?>"/><br/>

        <label for="year">Year to generate the report for</label><br/>
        <input type="text" name="year" value="<?=date('Y')?>"/><br/>

        <label for="avg_start_time">Average starting time</label><br/>
        <input type="text" name="avg_start_time" value="9:00"/><br/>

        <label for="nowork">Days you didn't work, comma separated (eg, 11,14)</label><br/>
        <input type="text" name="nowork"/><br/>
        <hr/>
        <input type="submit"  />
        <input type="hidden" name="submit" value="yes"/>
    </form>
</html>