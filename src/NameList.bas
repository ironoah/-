'--------------------------------------------------
'VBA の標準モジュールのみです。

Sub NamesListsOut()
'名前定義書き出し
Dim i As Integer
With ActiveWorkbook
For i = 1 To .Names.Count
　Cells(i, 1).Value = .Names(i).Name
　Cells(i, 2).Value = "'" & .Names(i).RefersToLocal
Next i
End With
End Sub

'--------------------------------------------------
Sub NamesListsIn()
'名前定義登録
Dim n As Name
Dim i As Integer

With ActiveWorkbook

'一旦名前定義を削除
For Each n In .Names
　n.Delete
Next n
'登録
On Error Resume Next
For i = 1 To Range("A65536").End(xlUp).Row
　 .Names.Add Cells(i, 1).Value, Cells(i, 2).Value
Next i
On Error GoTo 0
End With
End Sub
