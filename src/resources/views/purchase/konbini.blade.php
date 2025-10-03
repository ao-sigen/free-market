<h2>コンビニ払い情報</h2>
<p>支払期限: {{ $voucher->expires_at }}</p>
<p>支払いコード: {{ $voucher->payment_code }}</p>
<p><a href="{{ $voucher->hosted_voucher_url }}" target="_blank">支払い用ページを開く</a></p>