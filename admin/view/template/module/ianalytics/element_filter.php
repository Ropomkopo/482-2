<table cellpadding="0" cellspacing="0" class="iAnalyticsDateFilter">
    <tr>
    	<td>
            <select class="form-control iAnalyticsSelectBox">
                <option value="custom"<?php if (!$data['iAnalyticsSelectData']['enable'][0]) echo (' disabled="disabled" class="optionDisabled"'); if ($data['iAnalyticsSelectData']['select'][0]) echo (' selected="selected"'); ?>>Custom</option>
                <option value="last-week"<?php if (!$data['iAnalyticsSelectData']['enable'][1]) echo (' disabled="disabled" class="optionDisabled"'); if ($data['iAnalyticsSelectData']['select'][1]) echo (' selected="selected"'); ?>>Last Week</option>
                <option value="last-month"<?php if (!$data['iAnalyticsSelectData']['enable'][2]) echo (' disabled="disabled" class="optionDisabled"'); if ($data['iAnalyticsSelectData']['select'][2]) echo (' selected="selected"'); ?>>Last Month</option>
                <option value="last-year"<?php if (!$data['iAnalyticsSelectData']['enable'][3]) echo (' disabled="disabled" class="optionDisabled"'); if ($data['iAnalyticsSelectData']['select'][3]) echo (' selected="selected"'); ?>>Last Year</option>
            </select>
   		</td>
        <td class="form-inline">
        <label>From:</label>
        <input value="<?php echo $data['iAnalyticsFromDate'];?>" class="fromDate form-control" data-date-format="YYYY-MM-DD" style="width:100px;padding:10px;" type="text" maxlength="10" />
        </td>
        <td class="form-inline">
        <label>To:</label>
        <input value="<?php echo $data['iAnalyticsToDate'];?>" class="toDate form-control" data-date-format="YYYY-MM-DD" style="width:100px;padding:10px;" type="text" maxlength="10" />
    	</td>
        <td>
        <button type="button" class="btn btn-warning dateFilterButton"><i class="fa fa-filter"></i>&nbsp; Filter</button>
        </td>
    </tr>
</table>
<div class="clearfix"></div>