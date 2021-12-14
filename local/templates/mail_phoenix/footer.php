<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
						</td>
					</tr>
					<tr>
						<td height="65"></td>
					</tr>
				    <tr>
				        <td>
				          <table width="100%">
				            <tbody>
				            <tr>
				              <td valign="top">
				                <p style="margin: 0; padding: 0 0 10px 0;"><b style="font-size: 14px !important; color: #333;">+7 (863) 261-89-62</b></p><a href="mailto:sale@phoenix-plus.ru" style="color: #333;"><span>sale@phoenix-plus.ru</span></a>
				              </td>
				              <td valign="top">
				                <p style="margin: 0; padding: 0 0 10px 0;">Оставайтесь с нами</p>
				                <a href="https://vk.com/phoenixplusrostov" target="_blank" style="margin-right: 15px; text-decoration: none;  display: inline-block; font-size: 0; line-height: 25px; text-align: center;">
					                <img src="http://phoenix-plus.ru/local/templates/.default/i/vk.png" style="display: inline-block; display: block;">
					            </a>
					            
				                <a href="https://www.facebook.com/phoenixrostov/" target="_blank" style="margin-right: 15px; text-decoration: none;  display: inline-block; font-size: 0; line-height: 25px; text-align: center;">
					                <img src="http://phoenix-plus.ru/local/templates/.default/i/fb.png" style="display: inline-block; display: block;">
					            </a>   
					            
				                <a href="https://www.instagram.com/phoenix__plus/" target="_blank" style="margin-right: 15px; text-decoration: none;  display: inline-block; font-size: 0; line-height: 25px; text-align: center;">
					                <img src="http://phoenix-plus.ru/local/templates/.default/i/ig.png" style="display: inline-block; display: block;">
					            </a>
					            
				                <a href="https://ok.ru/group/58024346320952" target="_blank" style="margin-right: 15px; text-decoration: none;  display: inline-block; font-size: 0; line-height: 25px; text-align: center;">
					                <img src="http://phoenix-plus.ru/local/templates/.default/i/ok.png" style="display: inline-block; display: block;">
					            </a>
					                     
				              </td>
				              <?php if(0): ?>
					          	<td valign="middle" align="right"><a href="#" onclick="window.print()" style="color: #333;"><span>Распечатать</span></a></td>
					          <?php endif; ?>
				            </tr>
				          </tbody></table>
				        </td>
				      </tr>
				    </tbody>
				</table>
			</div>
		</div>
		<?php if (\Bitrix\Main\Loader::includeModule('mail')): ?>
			<?php echo \Bitrix\Mail\Message::getQuoteEndMarker(true); ?>
		<?php endif; ?>
	</body>
</html>