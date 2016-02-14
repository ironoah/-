
import java.util.*;

enum TknKind {
    Lparen, Rparen, Plus,  Minus,  Multi,  Divi,
    Assign,   Comma,  DblQ,
    Equal,    NotEq,  Less,  LessEq, Great,  GreatEq,
    If,       Else,   End,   Print,  Ident,  IntNum,
    String,   Letter, Digit, EofTkn, Others, END_list	
}

class Token {
	private static final int DEFAULT_INTVAL = 0;
    TknKind kind;                           /* トークンの種類   */
    String text;                            /* トークン文字列   */
    int  intVal;                            /* 定数のときその値 */
    Token () { kind = TknKind.Others; text = ""; intVal = 0; }
    Token (TknKind k, String s) {
        this(k, s, DEFAULT_INTVAL);
    }
    Token (TknKind k, String s, int d) {
        kind = k; text = s;  intVal = d;
    }
}

class KeyWord {                            /* 字句           */
    String keyName;
    TknKind keyKind;                        /* 種別           */
}

public class NTBoki {
	
	public static void main(String[] args){
		System.out.println("test");
	}
}
