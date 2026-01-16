import './bootstrap'
import Alpine from 'alpinejs'

window.Alpine = Alpine
Alpine.start()


window.openEditModal = (id, title, priority, description, start, end) => {
    document.getElementById('edit_id').value = id
    document.getElementById('edit_title').value = title
    document.getElementById('edit_priority').value = priority
    document.getElementById('edit_description').value = description
    document.getElementById('edit_start_at').value = start
    document.getElementById('edit_end_at').value = end
    document.getElementById('editModal').classList.remove('hidden')
}

window.closeEditModal = () => {
    document.getElementById('editModal').classList.add('hidden')
}

document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('btnSubmitEdit')
    if (!btn) return

    btn.addEventListener('click', submitEdit)
})

function submitEdit() {
    const id = document.getElementById('edit_id').value

    axios.put(
        `${window.location.origin}/activities/${id}`,
        {
            title: document.getElementById('edit_title').value,
            priority: document.getElementById('edit_priority').value,
            description: document.getElementById('edit_description').value,
            start_at: document.getElementById('edit_start_at').value,
            end_at: document.getElementById('edit_end_at').value,
        }
    )
    .then(() => {
        closeEditModal()

        // feedback UX
        const alert = document.createElement('div')
        alert.className =
            'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded shadow z-50'
        alert.innerText = 'Aktivitas berhasil diperbarui'
        document.body.appendChild(alert)

        setTimeout(() => window.location.reload(), 800)
    })
    .catch(err => {
        console.error(err)
        alert(err.response?.data?.message || 'Gagal update')
    })
}
