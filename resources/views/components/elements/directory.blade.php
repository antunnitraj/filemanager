@props(['folder', 'selectedFolders'])

<div
    x-data="{ clickTimeout: null }"
    :class="{ '!bg-gray-200/50 !hover:bg-gray-200/60 !dark:bg-gray-700 !hover:dark:bg-gray-700 group': @json($selectedFolders).includes({{ $folder->id }}) }"
    x-on:click.stop="
        if (this.clickTimeout) {
            clearTimeout(this.clickTimeout)
        }
        
        const ctrlPressed = event.ctrlKey || event.metaKey;
        const isSelected = @json($selectedFolders).includes({{ $folder->id }});

        this.clickTimeout = setTimeout(() => {
            if (ctrlPressed) {
                $wire.toggleFolderSelection({{ $folder->id }});
            } else {
                if (!isSelected) {
                    $wire.clearSelection();
                    $wire.toggleFolderSelection({{ $folder->id }});
                }
            }
            
            $nextTick(() => {
                $wire.handleFolderClick({{ $folder->id }});
            });
        }, 200);
    "
    x-on:dblclick.stop="$wire.navigateToFolder({{ $folder->id }})"
    x-on:mousedown.stop=""
    data-id="{{ $folder->id }}"
    class="folder cursor-pointer mb-4 max-w-[137px] min-w-[137px] max-h-[137px] min-h-[137px] items-start p-2 mx-1 hover:bg-blue-100/30 hover:dark:bg-gray-700 text-center select-none">
        <x-livewire-filemanager::icons.folder class="mx-auto w-16 h-16 mb-2" />

        <div class="flex flex-wrap text-center">
            <span :class="{ 'bg-blue-500 text-white dark:bg-blue-700 group': @json($selectedFolders).includes({{ $folder->id }}) }" class="text-ellipsis overflow-hidden break-words w-full block text-xs max-w-[150px] dark:text-zinc-200 rounded">{{ $folder->name }}</span>
            <small :class="{ 'text-blue-900': @json($selectedFolders).includes({{ $folder->id }}) }" class="w-full block text-xs text-blue-500">{{ $folder->elements() }}</small>
        </div>
</div>
