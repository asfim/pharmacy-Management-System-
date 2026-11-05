@extends('admin.layouts.app')
@php $header = 'Pharma AI Assistant'; @endphp

@push('styles')
<!-- Marked JS for rendering AI Markdown tables, lists, and formatting -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<style>
    .ai-chat-container {
        height: calc(100vh - 280px);
        min-height: 500px;
    }
    .markdown-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 12px 0;
        font-size: 13px;
        background: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .markdown-content th {
        background: #f1f5f9;
        font-weight: 700;
        text-align: left;
        padding: 8px 12px;
        border-bottom: 2px solid #cbd5e1;
        color: #334155;
    }
    .markdown-content td {
        padding: 8px 12px;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
    }
    .markdown-content tr:last-child td {
        border-bottom: none;
    }
    .markdown-content tr:nth-child(even) {
        background: #f8fafc;
    }
    .markdown-content p {
        margin-bottom: 8px;
        line-height: 1.6;
    }
    .markdown-content ul, .markdown-content ol {
        margin-left: 20px;
        margin-bottom: 8px;
        list-style-type: disc;
    }
    .markdown-content h3 {
        font-size: 16px;
        font-weight: 700;
        margin-top: 6px;
        margin-bottom: 8px;
        color: #0f172a;
    }
    .markdown-content h4 {
        font-size: 14px;
        font-weight: 700;
        margin-top: 4px;
        margin-bottom: 6px;
        color: #1e293b;
    }
    .markdown-content code {
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
        font-family: monospace;
        font-size: 12px;
        color: #0f766e;
    }
    .markdown-content blockquote {
        border-left: 4px solid #0d9488;
        padding-left: 12px;
        color: #0f766e;
        background: #f0fdfa;
        padding-top: 6px;
        padding-bottom: 6px;
        border-radius: 0 8px 8px 0;
        margin: 10px 0;
    }
</style>
@endpush

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2">
            <h2 class="text-2xl font-black text-slate-800 flex items-center gap-2.5">
                <span class="w-9 h-9 rounded-xl bg-gradient-to-tr from-teal-600 to-emerald-500 text-white flex items-center justify-center shadow-md shadow-teal-500/20">
                    <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </span>
                Pharma AI Assistant
            </h2>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                Live DB Connected
            </span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Ask questions about expired medicines, stock availability, upcoming expiries, sales reports & more.</p>
    </div>

    <!-- Live Quick Stats Strip -->
    <div class="flex items-center gap-2 flex-wrap text-xs">
        <div class="bg-white px-3 py-1.5 rounded-xl border border-slate-200 shadow-xs flex items-center gap-2">
            <span class="text-slate-400">Medicines:</span>
            <span class="font-bold text-slate-800">{{ number_format($stats['total_medicines']) }}</span>
        </div>
        <div class="bg-white px-3 py-1.5 rounded-xl border border-slate-200 shadow-xs flex items-center gap-2">
            <span class="text-slate-400">Expired:</span>
            <span class="font-bold {{ $stats['expired_count'] > 0 ? 'text-rose-600' : 'text-emerald-600' }}">{{ $stats['expired_count'] }}</span>
        </div>
        <div class="bg-white px-3 py-1.5 rounded-xl border border-slate-200 shadow-xs flex items-center gap-2">
            <span class="text-slate-400">Near 30d:</span>
            <span class="font-bold text-amber-600">{{ $stats['near_30_count'] }}</span>
        </div>
        <div class="bg-white px-3 py-1.5 rounded-xl border border-slate-200 shadow-xs flex items-center gap-2">
            <span class="text-slate-400">Pending Orders:</span>
            <span class="font-bold text-teal-600">{{ $stats['pending_orders'] }}</span>
        </div>
    </div>
</div>

<!-- Main AI Chat Surface -->
<div class="bg-white rounded-2xl border-2 border-slate-200 shadow-xl overflow-hidden flex flex-col ai-chat-container">

    <!-- Chat Messages Window -->
    <div id="chatMessages" class="flex-1 p-5 sm:p-6 overflow-y-auto space-y-4 bg-slate-50/70">
        
        <!-- Welcome Message -->
        <div class="flex gap-3 max-w-3xl">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-teal-600 to-emerald-500 text-white flex-shrink-0 flex items-center justify-center shadow-md text-sm font-bold">
                AI
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-xs text-sm text-slate-700 leading-relaxed">
                <div class="font-bold text-slate-800 mb-1 flex items-center gap-2">
                    <span>PharmaSys AI Assistant</span>
                    <span class="text-[10px] font-semibold text-teal-600 bg-teal-50 px-2 py-0.5 rounded-md border border-teal-100">Live Database Ready</span>
                </div>
                <p>Hello! I am connected to your live pharmacy database. You can ask me questions in <strong>English, বাংলা or Banglish</strong>.</p>
                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                    <div class="p-2.5 rounded-lg bg-teal-50/60 border border-teal-100 text-teal-900">
                        <strong>⚡ Expiry Verification:</strong> "Ki ki medicine expire hoise?", "10 din por kon medicine expire hobe?"
                    </div>
                    <div class="p-2.5 rounded-lg bg-emerald-50/60 border border-emerald-100 text-emerald-900">
                        <strong>📦 Stock & Price Check:</strong> "Acedol medicine ta ase kina?", "Napa stock koto?"
                    </div>
                    <div class="p-2.5 rounded-lg bg-amber-50/60 border border-amber-100 text-amber-900">
                        <strong>⚠️ Inventory Alerts:</strong> "Low stock medicine list dao", "Reorder level check"
                    </div>
                    <div class="p-2.5 rounded-lg bg-blue-50/60 border border-blue-100 text-blue-900">
                        <strong>📊 Financial & Orders:</strong> "Ajker sales report", "Pending online orders koto?"
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Suggested Quick Prompts -->
    <div class="px-5 py-2.5 bg-slate-100/80 border-t border-slate-200 flex items-center gap-2 overflow-x-auto no-scrollbar" id="suggestionsContainer">
        <span class="text-[11px] font-semibold text-slate-400 shrink-0">💡 Quick Prompts:</span>
        <button type="button" onclick="sendPrompt('Ki ki medicine expire hoise?')" class="prompt-chip text-xs bg-white hover:bg-teal-50 hover:text-teal-700 text-slate-600 px-3 py-1 rounded-full border border-slate-200 transition shrink-0 shadow-2xs font-medium">
            🔴 Ki ki medicine expire hoise?
        </button>
        <button type="button" onclick="sendPrompt('10 din ba tar beshi por kon kon medicine expire hobe?')" class="prompt-chip text-xs bg-white hover:bg-teal-50 hover:text-teal-700 text-slate-600 px-3 py-1 rounded-full border border-slate-200 transition shrink-0 shadow-2xs font-medium">
            ⏳ 10 din por kon medicine expire hobe?
        </button>
        <button type="button" onclick="sendPrompt('Acedol medicine ta ase kina?')" class="prompt-chip text-xs bg-white hover:bg-teal-50 hover:text-teal-700 text-slate-600 px-3 py-1 rounded-full border border-slate-200 transition shrink-0 shadow-2xs font-medium">
            💊 Acedol medicine ta ase kina?
        </button>
        <button type="button" onclick="sendPrompt('Ajker sales report koto?')" class="prompt-chip text-xs bg-white hover:bg-teal-50 hover:text-teal-700 text-slate-600 px-3 py-1 rounded-full border border-slate-200 transition shrink-0 shadow-2xs font-medium">
            📊 Ajker sales report koto?
        </button>
        <button type="button" onclick="sendPrompt('Low stock medicine gulo ki ki?')" class="prompt-chip text-xs bg-white hover:bg-teal-50 hover:text-teal-700 text-slate-600 px-3 py-1 rounded-full border border-slate-200 transition shrink-0 shadow-2xs font-medium">
            ⚠️ Low stock list
        </button>
    </div>

    <!-- Input Bar -->
    <div class="p-3 sm:p-4 bg-white border-t border-slate-200">
        <form id="aiChatForm" onsubmit="handleFormSubmit(event)" class="flex items-center gap-2">
            @csrf
            <div class="relative flex-1">
                <input type="text"
                       id="userMessageInput"
                       placeholder="Ask anything about medicines, stock, expiry dates, or sales reports..."
                       autocomplete="off"
                       class="w-full pl-4 pr-10 py-3 rounded-xl border-2 border-slate-200 text-sm focus:outline-none focus:border-teal-500 focus:ring-4 focus:ring-teal-50 transition shadow-xs text-slate-800 placeholder:text-slate-400">
                <button type="button" onclick="clearInput()" id="clearInputBtn" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <button type="submit"
                    id="submitBtn"
                    class="px-5 sm:px-6 py-3 rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center gap-2 shrink-0 disabled:opacity-50">
                <span>Ask AI</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const chatMessages = document.getElementById('chatMessages');
    const userMessageInput = document.getElementById('userMessageInput');
    const submitBtn = document.getElementById('submitBtn');
    const suggestionsContainer = document.getElementById('suggestionsContainer');

    function renderMarkdown(text) {
        if (typeof marked !== 'undefined') {
            return marked.parse(text);
        }
        // Fallback basic formatter
        return text
            .replace(/\n\n/g, '<br><br>')
            .replace(/\n/g, '<br>')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    }

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function appendUserMessage(message) {
        const div = document.createElement('div');
        div.className = 'flex justify-end gap-3';
        div.innerHTML = `
            <div class="bg-gradient-to-r from-teal-600 to-emerald-600 text-white rounded-2xl rounded-tr-xs p-3.5 sm:p-4 max-w-2xl text-sm shadow-md">
                ${escapeHtml(message)}
            </div>
        `;
        chatMessages.appendChild(div);
        scrollToBottom();
    }

    function appendTypingIndicator() {
        const id = 'typingIndicator_' + Date.now();
        const div = document.createElement('div');
        div.id = id;
        div.className = 'flex gap-3 max-w-3xl animate-fade-in';
        div.innerHTML = `
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-teal-600 to-emerald-500 text-white flex-shrink-0 flex items-center justify-center shadow-md text-sm font-bold">
                AI
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-xs p-4 shadow-xs text-sm text-slate-500 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-teal-500 animate-bounce"></span>
                <span class="w-2 h-2 rounded-full bg-teal-500 animate-bounce" style="animation-delay: 150ms;"></span>
                <span class="w-2 h-2 rounded-full bg-teal-500 animate-bounce" style="animation-delay: 300ms;"></span>
                <span class="text-xs text-slate-400 ml-1">Analyzing database records...</span>
            </div>
        `;
        chatMessages.appendChild(div);
        scrollToBottom();
        return id;
    }

    function appendAIMessage(markdownText, engine) {
        const div = document.createElement('div');
        div.className = 'flex gap-3 max-w-3xl';
        const formatted = renderMarkdown(markdownText);
        div.innerHTML = `
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-teal-600 to-emerald-500 text-white flex-shrink-0 flex items-center justify-center shadow-md text-sm font-bold">
                AI
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-xs p-4 sm:p-5 shadow-xs text-sm text-slate-700 leading-relaxed overflow-x-auto w-full">
                <div class="flex items-center justify-between gap-2 mb-2 pb-2 border-b border-slate-100 text-xs text-slate-400">
                    <span class="font-bold text-slate-700">PharmaSys AI Response</span>
                    <span class="text-[10px] font-semibold text-teal-600 bg-teal-50 px-2 py-0.5 rounded border border-teal-100">${escapeHtml(engine || 'Database Verified')}</span>
                </div>
                <div class="markdown-content">
                    ${formatted}
                </div>
            </div>
        `;
        chatMessages.appendChild(div);
        scrollToBottom();
    }

    function updateSuggestions(suggestions) {
        if (!suggestions || suggestions.length === 0) return;
        suggestionsContainer.innerHTML = '<span class="text-[11px] font-semibold text-slate-400 shrink-0">💡 Suggested:</span>';
        suggestions.forEach(q => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.onclick = () => sendPrompt(q);
            btn.className = 'prompt-chip text-xs bg-white hover:bg-teal-50 hover:text-teal-700 text-slate-600 px-3 py-1 rounded-full border border-slate-200 transition shrink-0 shadow-2xs font-medium';
            btn.textContent = q;
            suggestionsContainer.appendChild(btn);
        });
    }

    function escapeHtml(text) {
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    function sendPrompt(text) {
        userMessageInput.value = text;
        handleFormSubmit(new Event('submit'));
    }

    function clearInput() {
        userMessageInput.value = '';
        userMessageInput.focus();
    }

    async function handleFormSubmit(e) {
        if (e) e.preventDefault();
        const message = userMessageInput.value.trim();
        if (!message) return;

        appendUserMessage(message);
        userMessageInput.value = '';
        submitBtn.disabled = true;

        const typingId = appendTypingIndicator();

        try {
            const res = await fetch("{{ route('admin.ai.ask') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await res.json();
            const indicator = document.getElementById(typingId);
            if (indicator) indicator.remove();

            if (data.status === 'success') {
                appendAIMessage(data.reply, data.engine);
                updateSuggestions(data.suggestions);
            } else {
                appendAIMessage('⚠️ Sorry, could not process query. Please try again.');
            }
        } catch (err) {
            console.error(err);
            const indicator = document.getElementById(typingId);
            if (indicator) indicator.remove();
            appendAIMessage('⚠️ Network or server error occurred. Please verify your connection.');
        } finally {
            submitBtn.disabled = false;
            userMessageInput.focus();
        }
    }
</script>
@endpush

