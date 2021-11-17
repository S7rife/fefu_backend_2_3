<script type="text/javascript">
    let isAccepted = confirm("let's go to do an appeal");
    if (isAccepted)
    {
        let url = new URL("{{ route('appeal') }}");
        url.searchParams.append('accepted', '1');
        window.location.href = url;
    }
</script>
