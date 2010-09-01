<div id="{$properties.uniqueId}">
	<div class="{if isset($javascriptVariablesToSet.idSubtable)&& $javascriptVariablesToSet.idSubtable!=0}sub{/if}{if $javascriptVariablesToSet.viewDataTable=='tableAllColumns'}dataTableAllColumnsWrapper{elseif $javascriptVariablesToSet.viewDataTable=='tableGoals'}dataTableAllColumnsWrapper{else}dataTableWrapper{/if}" style="width:100%">
	{if isset($arrayDataTable.result) and $arrayDataTable.result == 'error'}
		{$arrayDataTable.message} 
	{else}
		{if count($arrayDataTable) == 0}
		<div class="pk-emptyDataTable">{'CoreHome_ThereIsNoDataForThisReport'|translate}</div>
		{else}
			<a name="{$properties.uniqueId}"></a>
			<table cellspacing="0" class="dataTable"> 
			<thead>
			<tr>
			{foreach from=$dataTableColumns item=column name=head}
				<th class="sortable {if $smarty.foreach.head.first}first{elseif $smarty.foreach.head.last}last{/if}" id="{$column}"><div id="thDIV">{$columnTranslations[$column]}</div></th>
			{/foreach}
			</tr>
			</thead>
			
			<tbody>
			{foreach from=$arrayDataTable item=row}
			<tr {if $row.idsubdatatable && $javascriptVariablesToSet.controllerActionCalledWhenRequestSubTable != null}class="subDataTable" id="{$row.idsubdatatable}"{/if}>
{foreach from=$dataTableColumns item=column}
<td style="width:auto">
{if isset($row.metadata.url[$column])}<a class="urlLink" href="{$row.metadata.url[$column]}" target="_blank">{/if}
{if isset($row.columns[$column])}{$row.columns[$column]}{else}{$defaultWhenColumnValueNotDefined}{/if}
{if isset($row.metadata.url[$column])}</a>{/if}
</td>
{/foreach}
			</tr>
			{/foreach}
			</tbody>
			</table>
		{/if}
		
		{if $properties.show_footer}
			{include file="CoreHome/templates/datatable_footer.tpl"}
		{/if}
		{include file="CoreHome/templates/datatable_js.tpl"}
	{/if}
	</div>
</div>
