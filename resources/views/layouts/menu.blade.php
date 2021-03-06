<nav class="bg-gray-200 shadow-lg" >
  <div class="container mx-auto py-3">

  <div class="flex px-3 justify-between">
    
    <div class="flex" >
    <a href="/" class="mr-10 text-2xl font-bold" >Mailness</a>

    <ul class="flex pt-2" >
      <li class="pr-5">
        <a href="{{ route('lists.index') }}" class="hover:text-gray-500 hover:underline" >Lists</a>
      </li>
      <li class="pr-5" >
        <a href="{{ route('campaigns.index') }}">Campaigns</a>
      </li>
      <li class="pr-5" >
        <a href="{{ route('templates.index') }}">Templates</a>
      </li>
      <li class="pr-5" >
        <a href="{{route('reports.index') }}">Reports</a>
      </li>
    </ul>
    </div>

    <ul class="flex pt-2" >
    <li>
        <a href="{{ route('settings.index') }}">Settings</a>
      </li>
      <li>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="pl-3" type="submit" >Logout</button>
        </form>
      </li>
    </ul>
  </div>

  </div>
</nav>