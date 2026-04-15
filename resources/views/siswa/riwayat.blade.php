<tr class="hover:bg-slate-50/50 transition-colors group">
    <td class="px-8 py-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-50 rounded-xl flex flex-col items-center justify-center text-indigo-600 shadow-sm border border-indigo-100">
                <span class="text-[9px] font-black leading-none uppercase">Code</span>
                <span class="text-[11px] font-bold">{{ $item->buku->kode_buku }}</span>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-800 leading-tight">{{ $item->buku->judul }}</p>
                <p class="text-[10px] text-gray-400 font-medium mt-1 uppercase tracking-widest">
                    {{ $item->buku->kategori }}
                </p>
            </div>
        </div>
    </td>
    </tr>