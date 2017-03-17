<?php if (@$gsExport == "") { ?>
<?php if (@!$gbSkipHeaderFooter) { ?>
			<!-- right column (end) -->
			<?php if (isset($gTimer)) $gTimer->Stop() ?>
		</td></tr>
	</table>
	<!-- content (end) -->
<?php if ($row_Mob['Mobile']==0) { ?>
	<!-- footer (begin) --><!-- *** Note: Only licensed users are allowed to remove or change the following copyright statement. *** -->
	</div>
					<div class="cleared"></div>
					<div class="art-footer">
						<div class="art-footer-t"></div>
						<div class="art-footer-l"></div>
						<div class="art-footer-b"></div>
						<div class="art-footer-r"></div>
						<div class="art-footer-body">
							<div class="art-footer-text">
								<br>
								<p>Copyright &copy; <?=date("Y", time());?>. <?php echo $Language->ProjectPhrase("BodyTitle") ?>. All Rights Reserved.</p>
								<br>
							</div>
							<div class="cleared"></div>
						</div>
					</div>
					<div class="cleared"></div>
				</div>
			</div>
			<div class="cleared"></div>
			<p class="art-page-footer"></p>
		</div>
	<!-- footer (end) -->	
<?php } ?>
</div>
<?php } ?>
<?php if (@$gsExport == "" || @$gsExport == "print") { ?>
<?php if (ew_IsMobile() AND $row_Mob['Mobile']==1) { ?>
	</div>
	<!-- footer (begin) --><!-- *** Note: Only licensed users are allowed to remove or change the following copyright statement. *** -->
	<div data-role="footer">
		<h4><?php echo $Language->ProjectPhrase("FooterText") ?></h4>
	</div>
	<!-- footer (end) -->	
</div>
<script type="text/javascript">
$("#ewPageTitle").html($("#ewPageCaption").text());
</script>
<?php } ?>
<?php if (@$_GET["_row"] <> "") { ?>
<script type="text/javascript">
jQuery.later(1000, null, function() {
	jQuery("#<?php echo $_GET["_row"] ?>").each(function() { this.scrollIntoView(); }
});
</script>
<?php } ?>
<?php } ?>
<!-- email dialog -->
<div id="ewEmailDialog" class="modal hide" data-backdrop="false"><div class="modal-header" style="cursor: move;"><h3></h3></div>
<div class="modal-body">
<?php include_once "ewemail10.php" ?>
</div><div class="modal-footer"><a href="#" class="btn btn-primary ewButton"><?php echo $Language->Phrase("SendEmailBtn") ?></a><a href="#" class="btn ewButton" data-dismiss="modal" aria-hidden="true"><?php echo $Language->Phrase("CancelBtn") ?></a></div></div>
<!-- message box -->
<div id="ewMsgBox" class="modal hide" data-backdrop="false"><div class="modal-body"></div><div class="modal-footer"><a href="#" class="btn btn-primary ewButton" data-dismiss="modal" aria-hidden="true"><?php echo $Language->Phrase("MessageOK") ?></a></div></div>
<!-- tooltip -->
<div id="ewTooltip"></div>
<?php } ?>
<?php if (@$gsExport == "") { ?>
<script type="text/javascript">

// Write your global startup script here
// document.write("page loaded");

</script>
<?php } ?>
</body>
</html>
