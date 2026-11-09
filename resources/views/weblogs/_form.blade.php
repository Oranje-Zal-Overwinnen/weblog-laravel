@csrf

@if ($weblog->exists)
    @method('PUT')
@endif

<p>
    <label for="title">Titel</label>
    <input id="title" name="title" type="text" value="{{ old('title', $weblog->title) }}" required>
</p>

<p>
    <label for="text">Tekst</label>
    <textarea id="text" name="text" rows="10" required>{{ old('text', $weblog->text) }}</textarea>
</p>

<p>
    <label for="categories">Categorieën</label>
    <select id="categories" name="categories[]" multiple>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(in_array($category->id, old('categories', $weblog->categories->modelKeys())))>
                {{ $category->title }}
            </option>
        @endforeach
    </select>
    <a href="{{ route('categories.create') }}">Nieuwe categorie toevoegen</a>
</p>

<p>
    <label for="image">Afbeelding</label>
    <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/webp" hidden>
    <button type="button" onclick="document.getElementById('image').click()">Afbeelding uploaden</button>
</p>

<p>
    <label>
        <input type="checkbox" name="is_premium" value="1" @checked(old('is_premium', $weblog->is_premium))>
        Markeer als Premium
    </label>
</p>

<button type="submit">Opslaan</button>
