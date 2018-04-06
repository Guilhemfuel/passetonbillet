<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <a href="{{route('contact.page')}}" style="color: white; text-decoration: none;">A problem? Contact us</a>
                </td>
            </tr>
            <tr>
                <td class="content-cell" align="center">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                </td>
            </tr>
        </table>
    </td>
</tr>
