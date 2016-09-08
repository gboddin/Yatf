<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>PHP Timeclock 1.04 - Hours Worked Report</title>


    <link rel="stylesheet" type="text/css" media="screen" href="templates/default.css">
    <link rel="stylesheet" type="text/css" media="print" href="templates/print.css">

    <style>
        .cpYearNavigation, .cpMonthNavigation {
            background-color: #cdc0b0;
            text-align: center;
            vertical-align: center;
            text-decoration: none;
            color: #000000;
            font-family: Tahoma;
            border-width: 0px 0px 1px 0px;
            border-style: solid;
            border-color: #748771;
        }

        .cpDayColumnHeader, .cpYearNavigation, .cpMonthNavigation, .cpCurrentMonthDate, .cpCurrentMonthDateDisabled, .cpOtherMonthDate, .cpOtherMonthDateDisabled, .cpCurrentDate, .cpCurrentDateDisabled, .cpTodayText, .cpTodayTextDisabled, .cpText {
            font-family: Tahoma;
            font-size: 11px;
        }

        TD.cpDayColumnHeader {
            text-align: right;
            border: solid thin #C0C0C0;
            border-width: 0px 0px 1px 0px;
        }

        .cpCurrentMonthDate, .cpOtherMonthDate, .cpCurrentDate {
            text-align: right;
            text-decoration: none;
        }

        .cpCurrentMonthDateDisabled, .cpOtherMonthDateDisabled, .cpCurrentDateDisabled {
            color: #D0D0D0;
            text-align: right;
            text-decoration: line-through;
        }

        .cpCurrentMonthDate, .cpCurrentDate {
            color: #000000;
        }

        .cpOtherMonthDate {
            color: #808080;
        }

        TD.cpCurrentDate {
            color: white;
            background-color: #eeeeee;
            border-width: 1px;
            border: solid thin #748771;
        }

        TD.cpCurrentDateDisabled {
            border-width: 1px;
            border: solid thin #FFAAAA;
        }

        TD.cpTodayText, TD.cpTodayTextDisabled {
            border: solid thin #C0C0C0;
            border-width: 1px 0px 0px 0px;
        }

        A.cpTodayText, SPAN.cpTodayTextDisabled {
            height: 20px;
        }

        A.cpTodayText {
            color: black;
        }

        .cpTodayTextDisabled {
            color: #D0D0D0;
        }

        .cpBorder {
            border: solid thin #748771;
            border-width: 1px 1px 1px 1px;
        }
    </style>

</head>
<body onload="office_names();">
<table class="misc_items" width="80%" align="center" border="0" cellpadding="3" cellspacing="0">
    <tbody>
    <tr>
        <td style="font-size:9px;color:#000000;" width="80%">Run on: <?=date('g:i a, d/m/Y')?></td>
        <td style="font-size:9px;color:#000000;" nowrap="nowrap">
            <?=$_POST['name']?></td>
    </tr>
    <tr>
        <td width="80%"></td>
        <td style="font-size:9px;color:#000000;" nowrap="nowrap">
            Date Range: 1/<?=$_POST['month']?>/<?=$_POST['year']?> - <?=$days_in_month?>/<?=$_POST['month']?>
            /<?=$_POST['year']?>
        </td>
    </tr>
    </tbody>
</table>
<table class="misc_items" width="80%" align="center" border="0" cellpadding="3" cellspacing="0">
    <tbody>
    <tr>
        <td colspan="2" style="font-size:11px;color:#000000;border-style:solid;border-color:#888888;
          border-width:0px 0px 1px 0px;" width="100%"><b><?=$_POST['name']?></b></td>
    </tr>
    <tr>
        <td style="color:#27408b;" nowrap="nowrap" width="75%" align="left"><b><u>Date</u></b></td>
        <td style="color:#27408b;" nowrap="nowrap" width="25%" align="left"><b><u>Hours Worked</u></b></td>
    </tr>
<?php
//Warning, sysadmin code incoming
$i = 1;
$total_worked = 0;
while ($i <= $days_in_month) {

    $unix_time = strtotime($_POST['year'].'/'.$_POST['month'].'/'.$i.' '.$_POST['avg_start_time']);
    $i++;


    if(in_array(date('w',$unix_time),array(0,6)) || in_array(date('d',$unix_time),$days_not_worked)) {
        continue;
    }
    // generate data :
    // decide how many minutes we slack :
    $start_slack = rand(1,20);
    $end_slack = rand(1,20);

    $start_slack = rand(0,1) ?  $start_slack : (0-$start_slack);
    $end_slack = rand(0,1) ?  $end_slack : (0-$end_slack);


    $start_date = $unix_time + (60*$start_slack);
    $end_date = $unix_time + (60*$end_slack) + (7.6*60*60);

?>
    <tr align="left" bgcolor="#FBFBFB">
        <td style="color:#000000;border-style:solid;border-color:#888888;
                            border-width:1px 0px 0px 0px;" nowrap="nowrap"><?=date('l d/m/Y',$unix_time)?></td>
        <td style="color:#000000;padding-left:31px;border-style:solid;border-color:#888888;
                                border-width:1px 0px 0px 0px;"
            nowrap="nowrap"><?=round(($end_date-$start_date)/60/60,2)?></td>
    </tr>
    <tr>
        <td colspan="2" width="100%">
            <table class="misc_items" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr align="left" bgcolor="#EFEFEF">
                    <td style="color:#009900;" nowrap="nowrap" width="13%" align="left">in</td>
                    <td style="padding-right:25px;" nowrap="nowrap" width="10%"
                        align="right"><?=date('g:i a',$start_date)?></td>
                    <td width="77%"></td>
                </tr>
                <tr align="left" bgcolor="#FBFBFB">
                    <td style="color:#FF0000;" nowrap="nowrap" width="13%" align="left">out</td>
                    <td style="padding-right:25px;" nowrap="nowrap" width="10%"
                        align="right"><?=date('g:i a',$end_date)?></td>
                    <td width="77%"></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

<?php
          $total_worked  += round(($end_date-$start_date)/60/60,2);
          //end while
}
?>
    <tr align="left">
        <td style="font-size:11px;color:#000000;border-style:solid;border-color:#888888;
                              border-width:1px 0px 0px 0px;" nowrap="nowrap"><b>Total Hours</b></td>
        <td style="font-size:11px;color:#000000;border-style:solid;border-color:#888888;
                          border-width:1px 0px 0px 0px;padding-left:15px;" nowrap="nowrap"><b><?=$total_worked?></b>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border-style:solid;border-color:#888888;border-width:1px 0px 0px 0px;" height="40">
            &nbsp;</td>
    </tr>
    </tbody>
</table>
</body>
</html>