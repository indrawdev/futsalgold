<?php if (@$gsExport == "") { ?>
				<p>&nbsp;</p>			
			<!-- right column (end) -->
			<?php if (isset($gsTimer)) $gsTimer->Stop() ?>
	    </td>	
		</tr>
	</table>
	<!-- content (end) -->	
	<!-- footer (begin) --><!-- *** Note: Only licensed users are allowed to remove or change the following copyright statement. *** -->
	</div>
                </div>
                <div class="cleared"></div><div class="art-Footer">
                    <div class="art-Footer-inner">
                        <div class="art-Footer-text">
                            <p>Sistem Informasi Persewaan Lapangan Futsal
                                <BR>Copyright &copy; <?=date("Y",time());?> Digital-Store.Web.ID . All Rights Reserved.</p>
                        </div>
                    </div>
                    <div class="art-Footer-background"></div>
                </div>
        		<div class="cleared"></div>
            </div>
        </div>
        <div class="cleared"></div>
        <p class="art-page-footer"></p>
    </div>
	<!-- footer (end) -->	
</div>

<div class="yui-tt" id="ewTooltipDiv" style="visibility: hidden; border: 0px;" name="ewTooltipDivDiv"></div>
<?php } ?>
<script type="text/javascript">
<!--
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
ewDom.getElementsByClassName(EW_TABLE_CLASS, "TABLE", null, ew_SetupTable); // init the table
<?php } ?>
<?php if (@$gsExport == "") { ?>
ew_InitEmailDialog(); // Init the email dialog
<?php } ?>

//-->
</script>
<?php if (@$gsExport == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your global startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
</body>
</html>
