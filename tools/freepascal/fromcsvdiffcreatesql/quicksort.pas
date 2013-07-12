unit quicksort;
// from http://delphi.about.com/od/objectpascalide/a/quicksort.htm
// Implementing QuickSort Sorting Algorithm in Delphi
// By Zarko Gajic
{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils; 

type TSortable = class(TObject)
    public
        value    : Longint;  // value on which sorting is performed
        position : Longint;  // value which is carried along
end;
type PSortable = ^TSortable;
type TArrayOfPSortable = Array of PSortable;

procedure QuickSort(var A: array of Integer; iLo, iHi: Integer) ;
// sorts using values in A, performs same operation on B
procedure QuickSortRelations(var A, B: array of Integer; iLo, iHi: Integer) ;

// uses TSortable.value to sort the array
procedure QuickSortSortable(A : TArrayOfPSortable; iLo, iHi: Integer) ;

implementation

procedure QuickSort(var A: array of Integer; iLo, iHi: Integer) ;
 var
   Lo, Hi, Pivot, T: Integer;
 begin
   Lo := iLo;
   Hi := iHi;
   Pivot := A[(Lo + Hi) div 2];
   repeat
     while A[Lo] < Pivot do Inc(Lo) ;
     while A[Hi] > Pivot do Dec(Hi) ;
     if Lo <= Hi then
     begin
       T := A[Lo];
       A[Lo] := A[Hi];
       A[Hi] := T;
       Inc(Lo) ;
       Dec(Hi) ;
     end;
   until Lo > Hi;
   if Hi > iLo then QuickSort(A, iLo, Hi) ;
   if Lo < iHi then QuickSort(A, Lo, iHi) ;
 end;

 // sorts using values in A, performs same operation on B
 procedure QuickSortRelations(var A, B: array of Integer; iLo, iHi: Integer) ;
 var
   Lo, Hi, Pivot, T: Integer;
 begin
   Lo := iLo;
   Hi := iHi;
   Pivot := A[(Lo + Hi) div 2];
   repeat
     while A[Lo] < Pivot do Inc(Lo) ;
     while A[Hi] > Pivot do Dec(Hi) ;
     if Lo <= Hi then
     begin
       T := A[Lo];
       A[Lo] := A[Hi];
       A[Hi] := T;

       T := B[Lo];
       B[Lo] := B[Hi];
       B[Hi] := T;

       Inc(Lo) ;
       Dec(Hi) ;
     end;
   until Lo > Hi;
   if Hi > iLo then QuickSortRelations(A, B, iLo, Hi) ;
   if Lo < iHi then QuickSortRelations(A, B, Lo, iHi) ;
 end;

procedure QuickSortSortable(A : TArrayOfPSortable; iLo, iHi: Integer) ;
 var
   Lo, Hi, Pivot, T: Integer;
 begin
   Lo := iLo;
   Hi := iHi;
   Pivot := A[(Lo + Hi) div 2]^.value;
   repeat
     while A[Lo]^.value < Pivot do Inc(Lo) ;
     while A[Hi]^.value > Pivot do Dec(Hi) ;
     if Lo <= Hi then
     begin
       T := A[Lo]^.value;
       A[Lo]^.value := A[Hi]^.value;
       A[Hi]^.value := T;
       Inc(Lo) ;
       Dec(Hi) ;
     end;
   until Lo > Hi;
   if Hi > iLo then QuickSortSortable(A, iLo, Hi) ;
   if Lo < iHi then QuickSortSortable(A, Lo, iHi) ;
 end;


end.

