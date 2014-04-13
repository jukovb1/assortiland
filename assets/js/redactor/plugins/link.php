
<form id="redactorInsertLinkForm">

<table class="redactor_ruler">
	<tr>
		<td nowrap id="redactor_link_url_name">URL</td>
		<td width="100%" id="redactor_link_url_td"><input name="redactor_link_url" id="redactor_link_url" style="width: 99%;"  /></td>
	</tr>
	<tr>
		<td>%RLANG.text%</td>
		<td id="redactor_link_text_td"><input name="redactor_link_text" id="redactor_link_text" style="width: 99%;" /></td>
		
	</tr>
    <tr>
        <td>%RLANG.title%</td>
        <td><input name="redactor_link_title" id="redactor_link_title"  style="width: 99%;"   /></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="button" name="" id="" value="%RLANG.insert%" onclick="redactorActive.insertLink();" />&nbsp;&nbsp;
            <input type="button" name="" onclick="redactorActive.modalClose();" value="%RLANG.cancel%"  /></td>
    </tr>
</table>



</form>


