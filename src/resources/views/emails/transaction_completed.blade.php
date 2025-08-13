@component('mail::message')
# 取引完了のお知らせ

{{ $purchase->profile->name }} さんが、
あなたの商品「{{ $purchase->item->name }}」の取引を完了しました。

{{ $purchase->profile->name }} さんの評価をしてください。

@component('mail::button', ['url' => $chatUrl])
評価をする
@endcomponent

ご利用ありがとうございます。<br>
{{ config('app.name') }}
@endcomponent
