@props(['id', 'name' => null, 'toolbar' => 'full', 'value' => '', 'acceptFiles' => false])

@php
  $isMini = $toolbar === 'mini';
@endphp

<div {{ $attributes->whereDoesntStartWith('wire:') }}
  @if ($attributes->has('wire:model')) x-data="{ content: $wire.entangle('{{ $attributes->wire('model')->value() }}') }"
    x-on:trix-initialize="$refs.input.value = content"
    x-on:trix-change="content = $refs.input.value" @endif>
  <input type="hidden" @if ($name ?? false) name="{{ $name }}" @endif id="{{ $id }}_input"
    value="{{ $value }}"
    @if ($attributes->has('wire:model')) x-on:change="$refs.input.value = $event.target.value"
        {{ $attributes->whereStartsWith('wire:') }} @endif />

  <trix-toolbar id="{{ $id }}_toolbar" @if ($attributes->has('wire:model')) wire:ignore @endif
    @class([
        '[&_.trix-button-group--block-tools]:hidden' => $isMini,
        '[&_.trix-button-group--file-tools]:hidden' => $isMini,
    ])></trix-toolbar>

  <trix-editor id="{{ $id }}" toolbar="{{ $id }}_toolbar" input="{{ $id }}_input"
    class="trix-content" @if ($attributes->has('wire:model')) x-ref="input"
    x-data="{
        uploadAttachment(event) {
            if (! event.attachment?.file) return

            const form = new FormData()
            form.append('attachment', event.attachment.file)

            fetch('/attachments', {
                method: 'POST',
                body: form,
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
                }
            }).then(resp => resp.json()).then((data) => {
                event.attachment.setAttributes({
                    url: data.attachment_url,
                    href: data.attachment_url,
                })
            }).catch(() => event.attachment.remove())
        }
    }"
        wire:ignore @endif
    @if ($acceptFiles) x-on:trix-attachment-add="uploadAttachment"
    @else
    x-on:trix-file-accept.prevent
    x-on:trix-attachment-add="$event.attachment.file && $event.attachment.remove()" @endif></trix-editor>
</div>


<script>
    addEventListener("trix-attachment-add", function(event) {
        alert("Event triggered from inside the Blade file!");
        event.attachment);
    });
</script>